<?php

namespace VdsEngineer\GigaGptIntegration\DTO;

class RequestDTO
{
    /**
     * @param  string[]  $context
     */
    public function __construct(
        public SettingDTO $setting,
        public array $context = [],
        public array $parameters = []
    ) {}
}
