<?php

function convertObjectDataToArray($data)
{
    $result = array();

    foreach ($data AS $key => $item) {
        $result[$key] = $item;
    }

    return $result;
}
