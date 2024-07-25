<?php

declare(strict_types=1);

function getRealIpAddr()
{
    $ipHeaders = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach ($ipHeaders as $header) {
        if (!empty($_SERVER[$header])) {
            $ipList = explode(',', $_SERVER[$header]);
            foreach ($ipList as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
    }
    return null;
}

function getCountryCode($ip)
{
    $url = "https://ipinfo.io/{$ip}/json";

    $response = file_get_contents($url);
    if ($response === FALSE) {
        return null;
    }

    $data = json_decode($response, true);

    return isset($data['country']) ? $data['country'] : null;
}

function filterWeatherData($apiData)
{
    $weatherData = [];
    $parsedData = json_decode($apiData, true);
    $currentDate = substr($parsedData['list'][0]['dt_txt'], 0, 10);

    $j = 0;
    for ($i = 0; $i < 4; $i++) {
        $k = 0;
        for ($j; $j < sizeof($parsedData['list']); $j++) {
            if ($currentDate === substr($parsedData['list'][$j]['dt_txt'], 0, 10)) {
                $weatherData[$i][$k] = $parsedData['list'][$j];
                $k++;
            } else if ($currentDate !== substr($parsedData['list'][$j]['dt_txt'], 0, 10)) {
                $currentDate = substr($parsedData['list'][$j]['dt_txt'], 0, 10);
                break;
            }
        }
    }

    return $weatherData;
}

function handleHighLowDayTemp($weatherData)
{
    $minDayTempArr = [INF, INF, INF, INF];
    $maxDayTempArr = [-INF, -INF, -INF, -INF];

    for ($i = 0; $i < 4; $i++) {
        for ($j = 0; $j < sizeof($weatherData[$i]); $j++) {
            // // Celsius = Kelvin - 273.15
            if ($weatherData[$i][$j]['main']['temp_min'] - 273.15 < $minDayTempArr[$i]) {
                $minDayTempArr[$i] = $weatherData[$i][$j]['main']['temp_min'] - 273.15;
            }
            if ($weatherData[$i][$j]['main']['temp_max'] - 273.15 > $maxDayTempArr[$i]) {
                $maxDayTempArr[$i] = $weatherData[$i][$j]['main']['temp_max'] - 273.15;
            }
        }
    }
    $minMaxDayTempArr = [$minDayTempArr, $maxDayTempArr];
    return $minMaxDayTempArr;
}

function handleWeatherData($weatherData)
{
    echo "<pre>" . print_r($weatherData, true) . "</pre>";
}



$visIp = getRealIpAddr();
$error = '';
if (array_key_exists('submit', $_GET)) {
    if (!$_GET['city']) {
        $error = 'Sorry, your input field is empty';
    }

    if ($_GET['city']) {
        $countryCode = getCountryCode($visIp);
        $apiData = @file_get_contents("https://api.openweathermap.org/data/2.5/forecast?q=" . $_GET['city'] . ',' . $countryCode . "&appid=" . $_ENV["API"]);
        if (!$apiData) {
            $apiData = @file_get_contents("https://api.openweathermap.org/data/2.5/forecast?q=" . $_GET['city'] . "&appid=" . $_ENV['API']);
            if (!$apiData) {
                $error = "City was not found";
            } else if ($apiData) {
                $weatherData = filterWeatherData($apiData);
                handleWeatherData($weatherData);
            }
        } else if ($apiData) {
            $weatherData = filterWeatherData($apiData);
            handleWeatherData($weatherData);
        }
    }
}
