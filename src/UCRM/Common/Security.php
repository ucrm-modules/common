<?php
declare(strict_types=1);

namespace UCRM\Common;

use MVQN\REST\RestClient;
use UCRM\Common\Config;



class Security
{

    public static function getCurrentUser(): ?array
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

        $url = "$protocol://$host$port";

        $headers = [
            "Content-Type: application/json",
            "Cookie: PHPSESSID=" . preg_replace('~[^a-zA-Z0-9]~', "", $_COOKIE["PHPSESSID"] ?? ""),
        ];

        $oldUrl = RestClient::getBaseUrl();
        $oldHeaders = RestClient::getHeaders();

        RestClient::setBaseUrl($url);
        RestClient::setHeaders($headers);

        $results =  RestClient::get("/current-user");

        RestClient::setBaseUrl($oldUrl);
        RestClient::setHeaders($oldHeaders);

        return $results;
    }


}