<?php

function keys_are_equal(array $array1, array $array2)
{
    $count1 = count($array1);
    $count2 = count($array2);

    if ($count1 != $count2) {
        return FALSE;
    }

    if ($count1 && $count2) {
        $string1 = implode('', $array1);
        $string2 = implode('', $array2);
        if ($string1 != $string2) {
            return FALSE;
        }
    }


    return TRUE;
}
