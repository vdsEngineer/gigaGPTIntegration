<?php

namespace VdsEngineer\GigaGptIntegration\Tests\Feature;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use VdsEngineer\GigaGptIntegration\GigaGpt;

class GigaGptTest extends TestCase
{
    public function testSetting(): void
    {
        $dotenv = Dotenv::createMutable(__DIR__.'/../..')->load();
        $gigaGpt = new GigaGpt($_ENV['AUTH_TOKEN']);
        $this->assertIsObject($gigaGpt);
        $setting = $gigaGpt->getSetting();
        $this->assertIsArray($setting);
        $this->assertArrayHasKey('auth', $setting);
        $this->assertArrayHasKey('model', $setting);
        $this->assertArrayHasKey('stream', $setting);
        $this->assertArrayHasKey('updateInterval', $setting);
        $this->assertArrayHasKey('xRequestId', $setting);
        $this->assertArrayHasKey('xSessionId', $setting);
        $this->assertArrayHasKey('xClientId', $setting);
        $this->assertArrayHasKey('RqUID', $setting);
        $this->assertArrayHasKey('functionCall', $setting);

        $settingArray = [
            'auth' => $_ENV['AUTH_TOKEN'],
            'token' => '',
            'model' => 'GigaChat',
            'stream' => true,
            'updateInterval' => 1,
            'xRequestId' => 'b6874da0-bf06-410b-a150-fd5f9164a0b2',
            'xSessionId' => '1234567890',
            'xClientId' => '1234567890',
            'RqUID' => '1234567890',
            'functionCall' => 'chatCompletionm',
        ];

        $gigaGpt->setSetting($settingArray);

        $this->assertEquals($settingArray['auth'], $gigaGpt->getSetting()['auth']);
        $this->assertEquals($settingArray['model'], $gigaGpt->getSetting()['model']);
        $this->assertEquals($settingArray['xRequestId'], $gigaGpt->getSetting()['xRequestId']);
    }

    public function testChatCompletion(): void
    {
        $dotenv = Dotenv::createMutable(__DIR__.'/../..')->load();
        $gigaGpt = (new GigaGpt($_ENV['AUTH_TOKEN']))->setToken();
        // success test
        /*$response = $gigaGpt->chatCompletionm('что умеет GigaChat');*/
        /*$this->assertIsString($response);*/
        // error test
        $gigaGpt = new GigaGpt($_ENV['AUTH_TOKEN']);
        try {
            $response = $gigaGpt->chatCompletion('что умеет GigaChat');

            $this->fail('Exception not thrown');
        } catch (\Throwable $th) {
        }

        $gigaGpt = (new GigaGpt($_ENV['AUTH_TOKEN']))->setToken();
        try {
            $response = $gigaGpt->chatCompletion();

            $this->fail('Exception not thrown');
        } catch (\Throwable $th) {}
    }

    /*public function testChatCompletionImage()*/
    /*{*/
    /*    Dotenv::createMutable(__DIR__.'/../..')->load();*/
    /**/
    /*    $gigaGpt = (new GigaGpt($_ENV['AUTH_TOKEN']))->setToken();*/
    /*    $response = $gigaGpt->chatCompletionImage('Нарисуй арт');*/
    /*    $this->assertIsString($response);*/
    /**/
    /*    return $gigaGpt;*/
    /*}*/

    /**
     * //depends testChatCompletionImage
     */
    /*public function testDownloadFile($gigaGpt): void*/
    /*{*/
    /*    $context = $gigaGpt->getContextGPT();*/
    /*    $content = $context[count($context) - 1]['content'];*/
    /*    $pattern = '/(")(\d||\w||-)*(")/U';*/
    /*    preg_match($pattern, $content, $matches);*/
    /*    $response = $gigaGpt->downloadFile(str_replace('"', '', $matches[0]));*/
    /*    $this->assertIsString($response);*/
    /*    file_put_contents(__DIR__.'/test.jpg', $response);*/
    /*    $this->assertFileExists(__DIR__.'/test.jpg');*/
    /*}*/

    public function testGetListModels(): void
    {
        Dotenv::createMutable(__DIR__.'/../..')->load();
        $gigaGpt = (new GigaGpt($_ENV['AUTH_TOKEN']))->setToken();
        $response = $gigaGpt->getListModels();
        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response[0]);
        $this->assertArrayHasKey('object', $response[0]);
        $this->assertArrayHasKey('type', $response[0]);
    }
}
