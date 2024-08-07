<?php

function getUrl()
{
    $url = parse_url(base_url());
    return "{$url["scheme"]}://{$url["host"]}/";
}

function getDomain()
{
    $url = parse_url(base_url());
    $domain = $url['host'];

    if (substr($domain, 0, 4) == 'www.') {
        $domain = substr($domain, 4);
    }

    return $domain;
}

function getUrlParameters()
{
    $CI = get_instance();

    if ($segments = $CI->uri->segment_array()) {
        return implode('/', array_slice($segments, 2));
    }

    return "";
}