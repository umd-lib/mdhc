<?php

$DOCUMENT_ROOT="..";

/** Removed for security reasons **/
$db_user = $_ENV["APPCONFIG_DB_USER"];
$db_password = $_ENV["APPCONFIG_DB_PASSWORD"];
$db_conn = $_ENV["APPCONFIG_DB_CONN"];
$db = $_ENV["APPCONFIG_DB_DATABASE"];



$conn = mysql_pconnect($db_conn,$db_user,$db_password);
mysql_select_db($db,$conn);

function formatdate($val)
{
// split up the timestamp
$year=substr($val,0,4);
$month=substr($val,4,2);
$day=substr($val,6,2);
$hh=substr($val,8,2);
$mm=substr($val,10,2);
// convert it into a standard timestamp and format it
$date = date("m-d-y", mktime($hh, $mm, 0, $month, $day, $year));
return $date;
}

function formatdate2($val)
{
// split up the timestamp
$year=substr($val,0,4);
$month=substr($val,4,2);
$day=substr($val,6,2);
$hh=substr($val,8,2);
$mm=substr($val,10,2);
// convert it into a standard timestamp and format it
$date = date("m/d/y h:i a", mktime($hh, $mm, 0, $month, $day, $year));
return $date;
}


?>
