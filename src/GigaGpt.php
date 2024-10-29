<?php

namespace VdsEngineer\GigaGptIntegration;

use Exception;
use VdsEngineer\GigaGptIntegration\DTO\SettingDTO;
use VdsEngineer\GigaGptIntegration\Services\APIService;
use VdsEngineer\GigaGptIntegration\Services\ContextService;

class GigaGpt
{
    private SettingDTO $setting;

    private ContextService $contextService;

    public function __construct(string $auth)
    {
        $this->setting = new SettingDTO(
            $auth,
        );

        $this->contextService = new ContextService;
    }

    public function setToken(): self
    {
        (new APIService)->initAccessToken($this->setting);

        return $this;
    }

    public function chatCompletion(string $messeges = ''): string
    {
        $this->checkToken();

        if (!empty($messeges)) {
            $this->contextService->pushContextUser($messeges);
        }

        $response = (new APIService)->chatCompletion($this->setting, $this->contextService);

        $messege = '';

        foreach ($response['choices'] as $item) {
            $messege = $item['message']['content'];
        }

        return $messege;
    }

    public function chatCompletionImage(string $messeges = ''): string
    {
        $this->checkToken();

        if (!empty($messeges)) {
            $this->contextService->pushContextUser($messeges);
        }

        $response = (new APIService)->chatCompletionImage($this->setting, $this->contextService);

        $messege = '';

        foreach ($response['choices'] as $item) {
            $messege = $item['message']['content'];
        }

        return $messege;
    }

    /**
     * @param  string[]  $input
     */
    public function getCountToken(array $input): array
    {
        $this->checkToken();

        return (new APIService)->getCountToken($this->setting, $input);
    }

    public function downloadFile(string $fileId): string
    {
        $this->checkToken();

        return (new APIService)->downloadFile($this->setting, $fileId);
    }

    public function getListModels(): array
    {
        $this->checkToken();

        return (new APIService)->getListModels($this->setting);
    }

    public function getSetting(): array
    {
        return $this->setting->toArray();
    }

    public function setSetting(array $setting): self
    {
        $this->setting = SettingDTO::fromArray($setting);

        return $this;
    }

    public function getContextGPT(): array
    {
        return $this->contextService->getContext();
    }

    public function setContextGPT(array $context): self
    {
        $this->contextService->setContext($context);

        return $this;
    }

    public function clearContextGPT(): self
    {
        $this->contextService->clearContext();

        return $this;
    }

    public function pushContextUserGPT(string $input): self
    {
        $this->contextService->pushContextUser($input);

        return $this;
    }

    public function pushContextSystemGPT(string $input): self
    {
        $this->contextService->pushContextSystem($input);

        return  $this;
    }

    private function checkToken(): void
    {
        if (empty($this->setting->token)) {
            throw new Exception('Token is not set');
        }
    }
}
