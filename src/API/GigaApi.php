<?php

namespace VdsEngineer\GigaGptIntegration\API;

use VdsEngineer\GigaGptIntegration\DTO\RequestDTO;
use VdsEngineer\GigaGptIntegration\DTO\ResponseDTO;
use VdsEngineer\GigaGptIntegration\Enum\Urls;

class GigaApi
{
    public function getAccessToken(RequestDTO $requestDTO): ResponseDTO
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => Urls::GET_ACCESS_TOKEN->value,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'scope=GIGACHAT_API_PERS',
            CURLOPT_HTTPHEADER => [
                'RqUID: ' . $requestDTO->setting->RqUID,
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer ' . $requestDTO->setting->auth,
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $this->preparationResponse($curl, $response);
    }

    public function chatCompletion(RequestDTO $requestDTO): ResponseDTO
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => Urls::CHAT_COMPLETIONS->value,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->preparationDataForChat($requestDTO), JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'X-Request-ID: ' . $requestDTO->setting->xRequestId,
                'X-Session-ID: ' . $requestDTO->setting->xSessionId,
                'X-Client-ID: ' . $requestDTO->setting->xClientId,
                'Authorization: Bearer ' . $requestDTO->setting->token,
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $this->preparationResponse($curl, $response);
    }

    public function chatCompletionImag(RequestDTO $requestDTO): ResponseDTO
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => Urls::CHAT_COMPLETIONS->value,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->preparationDataForChatImage($requestDTO), JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'X-Request-ID: ' . $requestDTO->setting->xRequestId,
                'X-Session-ID: ' . $requestDTO->setting->xSessionId,
                'X-Client-ID: ' . $requestDTO->setting->xClientId,
                'Authorization: Bearer ' . $requestDTO->setting->token,
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $this->preparationResponse($curl, $response);
    }

    public function downloadFile(RequestDTO $requestDTO): ResponseDTO
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => vsprintf(Urls::FILES_CONTENT->value, [$requestDTO->parameters['file_id']]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'X-Client-ID: ' . $requestDTO->setting->xClientId,
                'Authorization: Bearer ' . $requestDTO->setting->token,
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $this->preparationResponse($curl, $response);
    }

    public function getCountToken(RequestDTO $requestDTO): ResponseDTO
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => Urls::TOKEN_COUNT->value,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->preparationDataForCountToken($requestDTO)),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'X-Request-ID: ' . $requestDTO->setting->xRequestId,
                'X-Session-ID: ' . $requestDTO->setting->xSessionId,
                'X-Client-ID: ' . $requestDTO->setting->xClientId,
                'Authorization: Bearer ' . $requestDTO->setting->token,
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $this->preparationResponse($curl, $response);
    }

    public function getListModels(RequestDTO $requestDTO): ResponseDTO
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => Urls::MODEL_LIST->value,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $requestDTO->setting->token,
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $this->preparationResponse($curl, $response);
    }

    /*
     * @param CurlHandle $curl
     * @param array $response
     */
    private function preparationResponse($curl, $response): ResponseDTO
    {
        $typeContent = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

        if ($response === false) {
            $response = [];
        } else {
            if ($typeContent != 'image/jpeg') {
                $response = json_decode($response, true);
            }
        }

        return new ResponseDTO(
            curl_getinfo($curl, CURLINFO_HTTP_CODE),
            $response,
            curl_error($curl),
        );
    }

    /*
     * @return array<string, string>
     */
    private function preparationDataForCountToken(RequestDTO $requestDTO): array
    {
        return [
            'model' => $requestDTO->setting->model,
            'input' => $requestDTO->context,
        ];
    }

    /*
     * @return array<string, string>
     */
    private function preparationDataForChat(RequestDTO $requestDTO): array
    {
        return [
            'model' => $requestDTO->setting->model,
            'stream' => $requestDTO->setting->stream,
            'update_interval' => $requestDTO->setting->updateInterval,
            'messages' => $requestDTO->context,
        ];
    }

    /*
     * @return array<string, string>
     */
    private function preparationDataForChatImage(RequestDTO $requestDTO): array
    {
        $data = $this->preparationDataForChat($requestDTO);

        $data['function_call'] = $requestDTO->setting->functionCall;

        return $data;
    }
}
