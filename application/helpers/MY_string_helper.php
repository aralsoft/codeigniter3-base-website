<?php

function isJson($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function extractSentenceFromLanguageLine($line)
{
    $line = str_replace(array("\n", "\r"), '', $line);

    $line = strstr($line, "= '"); //gets all text from needle on
    $line = strstr($line, "';", true); //gets all text before needle

    return substr($line, 3);
}

function extractKeyFromLanguageLine($line)
{
    $line = strstr($line, "['"); //gets all text from needle on
    $line = strstr($line, "']", true); //gets all text before needle

    return substr($line, 2);
}
