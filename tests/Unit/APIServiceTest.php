<?php

namespace VdsEngineer\GigaGptIntegration\Tests\Unit;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Throwable;
use VdsEngineer\GigaGptIntegration\DTO\SettingDTO;
use VdsEngineer\GigaGptIntegration\Services\APIService;
use VdsEngineer\GigaGptIntegration\Services\ContextService;

class APIServiceTest extends TestCase
{
    public function testInitAccessToken(): void
    {
        $dotenv = Dotenv::createMutable(__DIR__.'/../..')->load();
        $settingDTO = new SettingDTO($_ENV['AUTH_TOKEN']);
        $contextService = new ContextService;

        $apiService = new APIService;
        $this->assertIsObject($apiService);

        $apiService->initAccessToken($settingDTO);
        $this->assertNotEmpty($settingDTO->token);
        $this->assertIsString($settingDTO->token);
        try {
            $settingDTO->auth = 'afdsa';
            $apiService->initAccessToken($settingDTO);

            $this->fail('Exception not thrown');
        } catch (Throwable $th) {
        }

    }

    public function testCountToken(): void
    {
        $dotenv = Dotenv::createMutable(__DIR__.'/../..')->load();
        $settingDTO = new SettingDTO($_ENV['AUTH_TOKEN']);
        $contextService = new ContextService;

        $apiService = new APIService;
        $apiService->initAccessToken($settingDTO);

        $input = [
            'Я к вам пишу — чего же боле?',
            'Что я могу еще сказать?',
            'Теперь, я знаю, в вашей воле',
            'Меня презреньем наказать.',
            'Но вы, к моей несчастной доле',
            'Хоть каплю жалости храня,',
            'Вы не оставите меня.',
        ];

        $countToken = $apiService->getCountToken($settingDTO, $input);

        $this->assertIsArray($countToken);
        $this->assertCount(7, $countToken);
        $this->assertArrayHasKey('object', $countToken[0]);
        $this->assertArrayHasKey('tokens', $countToken[0]);
        $this->assertArrayHasKey('characters', $countToken[0]);

        $input = [];

        $countToken = $apiService->getCountToken($settingDTO, $input);
        $this->assertIsArray($countToken);
        $this->assertCount(0, $countToken);
    }

    public function testGetListModels(): void
    {
        $dotenv = Dotenv::createMutable(__DIR__.'/../..')->load();

        $settingDTO = new SettingDTO($_ENV['AUTH_TOKEN']);
        $contextService = new ContextService;

        $apiService = new APIService;
        $apiService->initAccessToken($settingDTO);

        $listModels = $apiService->getListModels($settingDTO);
        $this->assertIsArray($listModels);
        foreach ($listModels as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('object', $item);
            $this->assertArrayHasKey('owned_by', $item);
        }
    }

    public function testChatCompletion(): void
    {
        $dotenv = Dotenv::createMutable(__DIR__.'/../..')->load();
        $settingDTO = new SettingDTO($_ENV['AUTH_TOKEN']);

        $contextService = (new ContextService)->setContext([
            [
                'role' => 'user',
                'content' => 'Что умеет GigaChat ?',
            ],
        ]);

        $apiService = new APIService;
        $apiService->initAccessToken($settingDTO);
        // success test
        /*$response = $apiService->chatCompletion($settingDTO, $contextService);*/
        /*$this->assertIsArray($response);*/
        /*$this->assertArrayHasKey('choices', $response);*/
        /*$this->assertArrayHasKey('message', $response['choices'][0]);*/
        /**/
        /*$context = $contextService->getContext();*/
        /*$this->assertSame('assistant', $context[1]['role']);*/

        // fail test
        $contextService->clearContext();
        try {
            $response = $apiService->chatCompletion($settingDTO, $contextService);
            $this->fail('Exception not thrown');
        } catch (\Throwable $th) {
        }

        $contextService->setContext([
            [
                'role' => 'user',
                'content' => 'Что умеет GigaChat ?',
            ],
        ]);

        try {
            $settingDTO->token = 'i892323fjyioyasdfahutnszcffr';
            $response = $apiService->chatCompletion($settingDTO, $contextService);
            $this->fail('Exception not thrown');
        } catch (\Throwable $th) {
        }
    }

    /*public function testChatCompletionImage(): array*/
    /*{*/
    /*    Dotenv::createMutable(__DIR__.'/../..')->load();*/
    /**/
    /*    $dotenv = Dotenv::createMutable(__DIR__.'/../..')->load();*/
    /*    $settingDTO = new SettingDTO($_ENV['AUTH_TOKEN']);*/
    /**/
    /*    $contextService = (new ContextService)->setContext([*/
    /*        [*/
    /*            'role' => 'user',*/
    /*            'content' => 'Что умеет GigaChat ?',*/
    /*        ],*/
    /*    ]);*/
    /**/
    /*    $apiService = new APIService;*/
    /*    $apiService->initAccessToken($settingDTO);*/
    /**/
    /*    $contextService = (new ContextService)->setContext([*/
    /*        [*/
    /*            'role' => 'system',*/
    /*            'content' => 'Ты — Василий Кандинский',*/
    /*        ],*/
    /*        [*/
    /*            'role' => 'user',*/
    /*            'content' => 'Нарисуй слона',*/
    /*        ],*/
    /*    ]);*/
    /**/
    /*    $response = $apiService->chatCompletionImage($settingDTO, $contextService);*/
    /*    $this->assertIsArray($response);*/
    /*    $this->assertArrayHasKey('choices', $response);*/
    /*    $this->assertArrayHasKey('message', $response['choices'][0]);*/
    /**/
    /*    $this->assertCount(3, $contextService->getContext());*/
    /*    $this->assertSame('assistant', $contextService->getContext()[count($contextService->getContext()) - 1]['role']);*/
    /**/
    /*    return ['context' => $contextService,  'setting' => $settingDTO];*/
    /*}*/

    /**
     * @depends testChatCompletionImage
     */
    /*public function testDownloadFile($data): void*/
    /*{*/
    /*    Dotenv::createMutable(__DIR__.'/../..')->load();*/
    /*    $settingDTO = $data['setting'];*/
    /*    $contextService = $data['context'];*/
    /**/
    /*    $contextArray = $contextService->getContext();*/
    /*    $content = $contextArray[count($contextArray) - 1]['content'];*/
    /*    $pattern = '/(")(\d||\w||-)*(")/U';*/
    /*    preg_match($pattern, $content, $matches);*/
    /*    $response = (new APIService)->downloadFile($settingDTO, str_replace('"', '', $matches[0]));*/
    /*    $this->assertNotNull($response);*/
    /*    $this->assertIsString($response);*/
    /*}*/
}
