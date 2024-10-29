<?php

namespace VdsEngineer\GigaGptIntegration\DTO;

use Exception;

class SettingDTO
{
    public function __construct(
        public string $auth,
        public string $xRequestId = '',
        public string $xSessionId = '',
        public string $xClientId = '',
        public string $RqUID = '',
        public string $token = '',
        public string $model = 'GigaChat',
        public bool $stream = false,
        public int $updateInterval = 0,
        public string $functionCall = 'auto',
    ) {
        if (empty($this->xRequestId)) {
            $this->xRequestId = self::guidv4();
        }

        if (empty($this->xSessionId)) {
            $this->xSessionId = self::guidv4();
        }

        if (empty($this->xClientId)) {
            $this->xClientId = self::guidv4();
        }

        if (empty($this->RqUID)) {
            $this->RqUID = self::guidv4();
        }
    }

    public function toArray()
    {
        return [
            'auth' => $this->auth,
            'token' => $this->token,
            'model' => $this->model,
            'stream' => $this->stream,
            'updateInterval' => $this->updateInterval,
            'xRequestId' => $this->xRequestId,
            'xSessionId' => $this->xSessionId,
            'xClientId' => $this->xClientId,
            'RqUID' => $this->RqUID,
            'functionCall' => $this->functionCall,
        ];
    }

    public static function fromArray(array $data): SettingDTO
    {
        if (empty($data['auth'])) {
            throw new Exception('Auth is required');
        }

        $setting = new SettingDTO($data['auth']);
        $setting->token = $data['token'] ?? '';
        $setting->model = $data['model'] ?? 'GigaChat';
        $setting->stream = $data['stream'] ?? false;
        $setting->updateInterval = $data['updateInterval'] ?? 0;
        $setting->xRequestId = $data['xRequestId'] ?? self::guidv4();
        $setting->xSessionId = $data['xSessionId'] ?? self::guidv4();
        $setting->xClientId = $data['xClientId'] ?? self::guidv4();
        $setting->RqUID = $data['RqUID'] ?? self::guidv4();
        $setting->functionCall = $data['functionCall'] ?? 'auto';

        return $setting;
    }

    private static function guidv4(): string
    {
        $data = random_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3F | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
