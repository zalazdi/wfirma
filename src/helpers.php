<?php

if (!function_exists('arrayGet')) {
    /**
     * Helper function for getting data from array
     *
     * @param mixed $var
     * @param mixed $default
     *
     * @return mixed
     */
    function arrayGet(&$var, $default = null)
    {
        return isset($var) ? $var : $default;
    }
}