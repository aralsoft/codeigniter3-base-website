<?php

function getLanguageLine($key)
{
    $CI = get_instance();

    $result = $CI->lang->line($key);

    if ($result !== FALSE) {
        return $result;
    }

    return ucfirst(str_replace('_', ' ', $key));
}

function getLanguageKey($key)
{
    $CI = get_instance();

    $key = $CI->method.'_'.$key;

    if (isset($CI->inputParameters['contentid'])) {
        if ($contentId = $CI->inputParameters['contentid']) {
            $key .= '_'.$contentId;
        }
    }

    return $key;
}