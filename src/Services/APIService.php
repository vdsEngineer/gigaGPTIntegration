<?php

namespace VdsEngineer\GigaGptIntegration\Services;

use Exception;
use VdsEngineer\GigaGptIntegration\API\GigaApi;
use VdsEngineer\GigaGptIntegration\DTO\RequestDTO;
use VdsEngineer\GigaGptIntegration\DTO\ResponseDTO;
use VdsEngineer\GigaGptIntegration\DTO\SettingDTO;

class APIService
{
    public function __construct() {}

    public function initAccessToken(SettingDTO $settingDTO): void
    {
        $requestDTO = new RequestDTO($settingDTO);

        $response = (new GigaApi)->getAccessToken($requestDTO);

        $this->validate($response);

        $settingDTO->token = $response->data['access_token'];
    }

    /**
     * @param  string[]  $input
     */
    public function getCountToken(SettingDTO $settingDTO, array $input): array
    {
        $requestDTO = new RequestDTO($settingDTO, $input);

        $response = (new GigaApi)->getCountToken($requestDTO);

        $this->validate($response);

        return $response->data;
    }

    public function getListModels(SettingDTO $settingDTO): array
    {
        $requestDTO = new RequestDTO($settingDTO);

        $response = (new GigaApi)->getListModels($requestDTO);

        $this->validate($response);

        return $response->data['data'];
    }

    public function chatCompletion(SettingDTO $settingDTO, ContextService $contextService): array
    {
        $contextService->valudateContext();

        $requestDTO = new RequestDTO($settingDTO, $contextService->getContext());

        $response = (new GigaApi)->chatCompletion($requestDTO);

        $this->validate($response);

        foreach ($response->data['choices'] as $choice) {
            $contextService->pushContextAssistant($choice['message']['content']);
        }

        return $response->data;
    }

    public function chatCompletionImage(SettingDTO $settingDTO, ContextService $contextService): array
    {
        $contextService->valudateContext();

        $requestDTO = new RequestDTO($settingDTO, $contextService->getContext());

        $response = (new GigaApi)->chatCompletionImag($requestDTO);

        $this->validate($response);

        foreach ($response->data['choices'] as $choice) {
            $contextService->pushContextAssistant($choice['message']['content']);
        }

        return $response->data;
    }

    public function downloadFile(SettingDTO $settingDTO, string $file_id)
    {
        $requestDTO = new RequestDTO(setting: $settingDTO, parameters: ['file_id' => $file_id]);

        $response = (new GigaApi)->downloadFile($requestDTO);

        $this->validate($response);

        return $response->data;
    }

    private function validate(ResponseDTO $data): void
    {
        if (! empty($data->error)) {
            throw new Exception($data->error, $data->status);
        }

        if ($data->status != 200) {
            throw new Exception($data->data['message'].' status: '.$data->status, $data->data['code']);
        }
    }
}
