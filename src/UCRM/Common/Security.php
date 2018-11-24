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

        $url = "$protocol://$host$port/current-user";

        $headers = [
            "Content-Type" => "application/json",
            "Cookie" => "PHPSESSID=" . preg_replace('~[^a-zA-Z0-9]~', "", $_COOKIE["PHPSESSID"] ?? ""),
        ];

        $oldHeaders = RestClient::getHeaders();

        $headerPairs = [];

        foreach($oldHeaders as $oldHeader)
        {
            $parts = explode(":", $oldHeader);
            $key = array_shift($parts);
            $value = implode(":", $parts);

            $headerPairs[$key] = $value;
        }

        $headerPairs = array_merge($headerPairs, $headers);

        $newHeaders = [];

        foreach($headerPairs as $key => $value)
        {
            $newHeaders[] = "$key: $value";
        }


        RestClient::setHeaders($newHeaders);

        $results =  RestClient::get($url);

        RestClient::setHeaders($oldHeaders);

        return $results;
    }









}