<?php

namespace Zalazdi\wFirma;

use GuzzleHttp\Exception\ClientException;
use Zalazdi\wFirma\Exceptions\AbsentOAuthParameterException;
use Zalazdi\wFirma\Exceptions\InvalidOAuthTokenException;
use Zalazdi\wFirma\Exceptions\TokenRejectedException;
use Zalazdi\wFirma\Exceptions\wFirmaException;

class OAuthClient extends AbstractClient
{
    /**
     * @var string API Url
     */
    protected $url = 'https://api2.wfirma.pl/';
    protected $oauthUrl = 'https://wfirma.pl/oauth';

    protected $key;
    protected $secret;

    protected $token;
    protected $tokenSecret;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;

    const SCOPE_CONTRACTORS_READ            = 'contractors-read';
    const SCOPE_CONTRACTORS_WRITE           = 'contractors-write';
    const SCOPE_COMPANIES_READ              = 'companies-read';
    const SCOPE_COMPANY_ACCOUNTS_READ       = 'company_accounts-read';
    const SCOPE_COMPANY_PACKS_READ          = 'company_packs-read';
    const SCOPE_DOCUMENTS_READ              = 'documents-read';
    const SCOPE_DOCUMENTS_WRITE             = 'documents-write';
    const SCOPE_EXPENSES_READ               = 'expenses-read';
    const SCOPE_GOODS_READ                  = 'goods-read';
    const SCOPE_GOOD_WRITE                  = 'goods-write';
    const SCOPE_INVOICES_READ               = 'invoices-read';
    const SCOPE_INVOICES_WRITE              = 'invoices-write';
    const SCOPE_INVOICE_DESCRIPTIONS_READ   = 'invoice_descriptions-read';
    const SCOPE_INVOICE_DELIVERIES_READ     = 'invoice_deliveries-read';
    const SCOPE_INVOICE_DELIVERIES_WRITE    = 'invoice_deliveries-write';
    const SCOPE_NOTES_READ                  = 'notes-read';
    const SCOPE_NOTES_WRITE                 = 'notes-write';
    const SCOPE_PAYMENTS_READ               = 'payments-read';
    const SCOPE_PAYMENTS_WRITE              = 'payments-write';
    const SCOPE_PAYMENT_CASHBOXES           = 'payment_cashboxes-read';
    const SCOPE_SERIES_READ                 = 'series-read';
    const SCOPE_SERIES_WRITE                = 'series-write';
    const SCOPE_STAFF_CALENDAR_WORK_ABSENCES = 'staff_calendar_work_absences-read';
    const SCOPE_STAFF_EMPLOYEES             = 'staff_employees-read';
    const SCOPE_TAGS_READ                   = 'tags-read';
    const SCOPE_TAGS_WRITE                  = 'tags-write';
    const SCOPE_TERMS_READ                  = 'terms-read';
    const SCOPE_TERMS_WRITE                 = 'terms-write';
    const SCOPE_TERM_GROUPS_READ            = 'term_groups-read';
    const SCOPE_TERM_GROUPS_WRITE           = 'term_groups-write';
    const SCOPE_USER_COMPANIES_READ         = 'user_companies-read';
    const SCOPE_USERS_READ                  = 'users-read';
    const SCOPE_WAREHOUSES_READ             = 'warehouses-read';
    const SCOPE_WEBHOOKS_READ               = 'webhooks-read';
    const SCOPE_WEBHOOKS_WRITE              = 'webhooks-write';

    /**
     * Client constructor.
     *
     * @param array $config API configuration
     */
    public function __construct(array $config = [])
    {
        $this->parseConfig($config);
        $this->guzzle = new \GuzzleHttp\Client();
    }

    public function setToken($token, $tokenSecret)
    {
        $this->token = $token;
        $this->tokenSecret = $tokenSecret;
    }

    /**
     * @param $callback
     * @param $scopes
     */
    public function requestToken($callback, $scopes = [])
    {
        $params = http_build_query([
            'scope' => implode(',', $scopes),
        ]);
        
        try {
            $response = $this->guzzle->get($this->oauthUrl.'/requestToken?' . $params, [
                'headers' => $this->prepareHeaders([
                    'oauth_callback' => $callback
                ]),
            ]);

            $contents = $response->getBody()->getContents();

            $result = [];
            foreach (explode('&', $contents) as $row) {
                list($key, $value) = explode('=', $row);

                $result[$key] = urldecode($value);
            }

            $result['redirect_url'] = 'https://wfirma.pl/oauth/authorize?oauth_token='.$result['oauth_token'];

            return $result;
        } catch (ClientException $exception) {
            $contents = $exception->getResponse()->getBody()->getContents();

            $result = [];
            foreach (explode('&', $contents) as $row) {
                list($key, $value) = explode('=', $row);

                $result[$key] = urldecode($value);
            }

            if (isset($result['oauth_problem'])) {
                switch ($result['oauth_problem']) {
                    case 'parameter_absent':
                        $params = explode('&', $result['oauth_parameters_absent']);
                        throw new AbsentOAuthParameterException('Parameters "'.implode(', ', $params).'" absent.');
                    case 'signature_invalid':
                        throw new InvalidOAuthTokenException('Invalid oAuth token or token secret.');
                }
            }

            throw new wFirmaException('wFirma Exception: '.$contents);
        }
    }

    public function accessToken($verifier)
    {
        $params = http_build_query([
            'oauth_verifier' => $verifier,
        ]);

        try {
            $response = $this->guzzle->get($this->oauthUrl.'/accessToken?' . $params, [
                'headers' => $this->prepareHeaders([
                    'oauth_verifier' => $verifier,
                ]),
            ]);

            $contents = $response->getBody()->getContents();

            $result = [];
            foreach (explode('&', $contents) as $row) {
                list($key, $value) = explode('=', $row);

                $result[$key] = urldecode($value);
            }

            return $result;
        } catch (ClientException $exception) {
            $contents = $exception->getResponse()->getBody()->getContents();

            $result = [];
            foreach (explode('&', $contents) as $row) {
                list($key, $value) = explode('=', $row);

                $result[$key] = urldecode($value);
            }

            if (isset($result['oauth_problem'])) {
                switch ($result['oauth_problem']) {
                    case 'parameter_absent':
                        $params = explode('&', $result['oauth_parameters_absent']);
                        throw new AbsentOAuthParameterException('Parameters "'.implode(', ', $params).'" absent.');
                    case 'signature_invalid':
                        throw new InvalidOAuthTokenException('Invalid oAuth token or token secret.');
                    case 'token_rejected':
                        throw new TokenRejectedException('Token rejected.');
                }
            }

            throw new wFirmaException('wFirma Exception: '.$contents);
        }
    }

    public function execute(Query $query, $json = true)
    {
        try {
            $response = $this->guzzle->post($this->url . '/' . $query->path, [
                'json' => $query->parameters,
                'headers' => $this->prepareHeaders(),
            ]);

            if ($json) {
                $body = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
            } else {
                $body = $response->getBody()->getContents();
            }

            return $body;
        } catch (ClientException $exception) {
            $contents = $exception->getResponse()->getBody()->getContents();
            $result = json_decode($contents);

            if ($result->status->code == 'AUTH') {
                throw new InvalidOAuthTokenException('Invalid oAuth token or token secret.');
            }
            
            throw $exception;
        }
    }

    protected function prepareHeaders($params = [], $useTokenSecret = true)
    {
        $params = array_merge([
            'oauth_consumer_key' => $this->key,
            'oauth_signature_method' => 'PLAINTEXT',
            'oauth_nonce' => $this->generateRandomString(),
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0',
            'oauth_signature' => $this->secret.'&'.($useTokenSecret ? $this->tokenSecret : ''),
        ], $params);

        if ($this->token) {
            $params['oauth_token'] = $this->token;
        }

        foreach ($params as $key => &$param) {
            $param = $key.'="'.urlencode($param).'"';
        }

        return [
            'Authorization' => 'OAuth '.implode(',', $params)
        ];
    }

    /**
     * Parse configuration
     *
     * @param array $config
     */
    protected function parseConfig(array $config = [])
    {
        $this->key = arrayGet($config['key']);
        $this->secret = arrayGet($config['secret']);
    }

    /**
     * Generate random string.
     *
     * @param int $length
     * @return string
     */
    protected function generateRandomString($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
