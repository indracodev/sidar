<?php

$my_latitude = "-8.85122103";
$my_longitude = "121.65814174";
$her_latitude = "-8.8478210";
$her_longitude = "121.6582410";

$distance = round((((acos(sin(($my_latitude*pi()/180)) * sin(($her_latitude*pi()/180))+cos(($my_latitude*pi()/180)) * cos(($her_latitude*pi()/180)) * cos((($my_longitude- $her_longitude)*pi()/180))))*180/pi())*60*1.1515*1.609344), 3);
echo $distance . 'km';

?>