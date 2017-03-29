<?php

function _encode($value) {
    if (is_array($value)) {
        //очистить от пустых значений массива
        $value = array_diff($value, array(''));
    }
    return htmlspecialchars(json_encode($value), ENT_QUOTES);
}

function _decode($value) {
    return json_decode(htmlspecialchars_decode($value, ENT_QUOTES));
}
