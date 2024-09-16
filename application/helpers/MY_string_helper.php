<?php

function isJson($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function extractSentenceFromLanguageLine($line)
{
    if ($line = strstr($line, "= '")) {
        return substr($line, 3);
    }

    return FALSE;
}

function extractKeyFromLanguageLine($line)
{
    if ($line = strstr($line, "['")) {
        return substr(strstr($line, "']", true), 2);
    }

    return FALSE;
}
