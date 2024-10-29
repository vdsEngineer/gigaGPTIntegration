<?php

namespace VdsEngineer\GigaGptIntegration\Tests\Unit;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use VdsEngineer\GigaGptIntegration\API\GigaApi;
use VdsEngineer\GigaGptIntegration\DTO\RequestDTO;
use VdsEngineer\GigaGptIntegration\DTO\SettingDTO;

class GigaApiTest extends TestCase
{
    public function testGetAccessToken(): void
    {
        $dotenv = Dotenv::createMutable(__DIR__.'/../..');
        $dotenv->load();

        $requestDTO = new RequestDTO(
            new SettingDTO($_ENV['AUTH_TOKEN'])
        );

        $responseDTO = (new GigaApi)->getAccessToken($requestDTO);

        $this->assertIsObject($responseDTO);
        $this->assertEquals(200, $responseDTO->status);
        $this->assertArrayHasKey('access_token', $responseDTO->data);
        $this->assertEmpty($responseDTO->error);
    }
}
