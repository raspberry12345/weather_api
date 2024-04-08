<?php

namespace App\Weather\Remote;

use App\Weather\WeatherContract;
use App\Weather\WeatherInfo;

class RemoteWeatherFetcher implements WeatherContract {
    public function getWeatherForCity(string $cityName): ?WeatherInfo {
        $fp = fsockopen("ssl://downloads.codingcoursestv.eu", 443, $errno, $errstr, 30);
        if (!$fp) {
            return null;
        } else {
            $out = "GET /052%20-%20php/wetter.json HTTP/1.1\r\n";
            $out .= "Host: downloads.codingcoursestv.eu\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fwrite($fp, $out);

            
            while (!feof($fp)) {
                $responseArray[] = fgets($fp, 128);
            }
            fclose($fp);
            $response = implode('', $responseArray);
            $responseSplitted = explode("\r\n", $response,2);
            if ($responseSplitted[0] === 'HTTP/1.1 200 OK') {
                $httpContent = explode("\r\n\r\n", $responseSplitted[1],2);
                $jsonHttpContent = trim($httpContent[1]);
                $decodedResponse = json_decode($jsonHttpContent, true);
                if (!empty($decodedResponse)) {
                    # code...
                    return new WeatherInfo($decodedResponse['temperature'], $decodedResponse['status'] === 'raining' );
                }
            }
            
        }
        return null;
        
    }
}