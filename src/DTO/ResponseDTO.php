<?php

namespace VdsEngineer\GigaGptIntegration\DTO;

class ResponseDTO
{
    /**
     * @param  mixed[]  $data
     */
    public function __construct(
        public int $status,
        public mixed $data,
        public string $error
    ) {}
}
