<?php
header("Content-Type:text/html;charset=utf-8");
$ILData = file_get_contents('http://tool.114la.com/?ct=site&ac=ip_api');
$ILData = str_replace('var ILData = ', '', $ILData);
$ILData = str_replace('; if (typeof(ILData_callback) != "undefined") { ILData_callback(); }', '', $ILData);
$ILData = json_decode($ILData);
$str = file_get_contents('http://tool.114la.com/static/weather/'.$ILData[4].'.txt');
$str = str_replace('var weatherJSON = ', '', $str);
print_r(json_decode($str));
?>