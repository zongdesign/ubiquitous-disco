<?php

declare(strict_types=1);


namespace App\Tests\Controller\Api;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ClassroomControllerTest extends TestCase
{
    public function testShow()
    {
        $client = new Client();
        $response = $client->request(
            'GET',
            'http://localhost:8000/api/classroom'
        );

        $this->assertEquals(
            '201',
            $response->getStatusCode()
        );

    }
}