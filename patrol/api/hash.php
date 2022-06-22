<?php
function generateHash($length = 50)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    $i = 0;
    while ($i < $length) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
        $i++;
    }
    return $randomString;
}
