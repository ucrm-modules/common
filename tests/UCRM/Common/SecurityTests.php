<?php
declare(strict_types=1);

namespace UCRM\Common;

use Dotenv\Dotenv;
use MVQN\REST\RestClient;

class SecurityTests extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        $env = (new Dotenv(__DIR__."/../../../"))->load();

        RestClient::setBaseUrl(getenv("UCRM_HOST_URL"));
        RestClient::setHeaders([
            "Content-Type: application/json",
            "X-Auth-App-Key: ".getenv("UCRM_REST_KEY"),
        ]);



    }


    public function testGetCurrentUser()
    {
        var_dump(Security::getCurrentUser());

    }



}