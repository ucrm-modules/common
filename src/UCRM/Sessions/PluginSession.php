<?php
declare(strict_types=1);

namespace UCRM\Sessions;

use UCRM\Common\Config;



class PluginSession
{
    private static function curlQuery(string $url, array $headers = [], array $parameters = []): array
    {
        if ($parameters) {
            $url .= '?' . http_build_query($parameters);
        }

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 2);

        $result = curl_exec($c);

        $error = curl_error($c);
        $errno = curl_errno($c);

        if ($errno || $error) {
            throw new \Exception(sprintf('Error for request %s. Curl error %s: %s', $url, $errno, $error));
        }

        $httpCode = curl_getinfo($c, CURLINFO_HTTP_CODE);

        if ($httpCode < 200 || $httpCode >= 300) {
            throw new \Exception(
                sprintf('Error for request %s. HTTP error (%s): %s', $url, $httpCode, $result),
                $httpCode
            );
        }

        curl_close($c);

        if (! $result) {
            throw new \Exception(sprintf('Error for request %s. Empty result.', $url));
        }

        $decodedResult = json_decode($result, true);

        if ($decodedResult === null) {
            throw new \Exception(
                sprintf('Error for request %s. Failed JSON decoding. Response: %s', $url, $result)
            );
        }

        return $decodedResult;
    }



    public static function getCurrentlyAuthenticated(): ?array
    {
        if(!isset($_COOKIE["PHPSESSID"]))
            return null;

        $sessionId = $_COOKIE["PHPSESSID"];
        $cookie = "PHPSESSID=" . preg_replace('~[^a-zA-Z0-9]~', '', $_COOKIE['PHPSESSID']);

        $host = Config::getServerFQDN();

        switch(Config::getServerPort())
        {
            case 80:
                $protocol = "http";
                $port = "";
                break;
            case 443:
                $protocol = "https";
                $port = "";
                break;
            default:
                $protocol = "http";
                $port = ":".Config::getServerPort();
                break;
        }

        $url = "$protocol://$host$port/current-user";

        $headers = [
            "Content-Type: application/json",
            "Cookie: PHPSESSID=" . preg_replace('~[^a-zA-Z0-9]~', "", $_COOKIE["PHPSESSID"] ?? ""),
        ];

        return self::curlQuery($url, $headers);
    }








}