<?php
header("Content-Type:text/html;charset=utf-8");

/**
 *求两个已知经纬度之间的距离,单位为米
 * @param lng1,lng2 经度
 * @param lat1,lat2 纬度
 * @return float 距离，单位米
 **/
function getdistance($lng1, $lat1, $lng2, $lat2) //根据经纬度计算距离
{
//将角度转为狐度
    $radLat1 = deg2rad($lat1);
    $radLat2 = deg2rad($lat2);
    $radLng1 = deg2rad($lng1);
    $radLng2 = deg2rad($lng2);
    $a = $radLat1 - $radLat2; //两纬度之差,纬度<90
    $b = $radLng1 - $radLng2; //两经度之差纬度<180
    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
    return $s;
}

//测试，返回结果 : 759.467618902
echo getdistance(116.4558029, 39.9167328, 116.460197, 39.910801);


//百度坐标转换成GPS坐标
$lnglat = '121.437518,31.224665';
function FromBaiduToGpsXY($lnglat)
{
// 经度,纬度
    $lnglat = explode(',', $lnglat);
    list($x, $y) = $lnglat;
    $Baidu_Server = "http://api.map.baidu.com/ag/coord/convert?from=0&to=4&x={$x}&y={$y}";
    //echo $Baidu_Server;
    $result = @file_get_contents($Baidu_Server);
    $json = json_decode($result);
    if ($json->error == 0) {
        $bx = base64_decode($json->x);
        $by = base64_decode($json->y);
        $GPS_x = 2 * $x - $bx;
        $GPS_y = 2 * $y - $by;
        return $GPS_x . ',' . $GPS_y; //经度,纬度
    } else
        return $lnglat;
}

/**********************************************/
function fn_rad($d)
{
    return $d * pi() / 180.0;
}

// 2点间算法
function P2PDistance($latlng1, $latlng2)
{
// 纬度1,经度1 ~ 纬度2,经度2
    $latlng1 = explode(',', $latlng1);
    $latlng2 = explode(',', $latlng2);
    list($lat1, $lng1) = $latlng1;
    list($lat2, $lng2) = $latlng2;
    $EARTH_RADIUS = 6378.137;
    $radLat1 = fn_rad($lat1);
    $radLat2 = fn_rad($lat2);
    $a = $radLat1 - $radLat2;
    $b = fn_rad($lng1) - fn_rad($lng2);
    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
    $s = $s * $EARTH_RADIUS;
    $s = round($s * 10000) / 10000;
    return number_format($s, 2);
}

echo '百度坐标: ', $lnglat, '<br ><br >', '转换后GPS坐标: ', FromBaiduToGpsXY($lnglat), ' <br /> ';
echo '转换前距离: ', P2PDistance('31.224286666667,121.420675', '31.224665,121.437518'), ' <br />';
echo '转换后距离: ', P2PDistance('31.224286666667,121.420675', '31.220157068379,121.42647022694');
?>