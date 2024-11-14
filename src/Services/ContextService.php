<?php

namespace VdsEngineer\GigaGptIntegration\Services;

use Exception;

class ContextService
{
    private $context = [];

    public function pushContextUser(string $input): self
    {
        return $this->pushContext('user', $input);
    }

    public function pushContextSystem(string $input): self
    {
        return $this->pushContext('system', $input);
    }

    public function pushContextAssistant(string $input): self
    {
        return $this->pushContext('assistant', $input);
    }

    /**
     * @param  string[]  $context
     * @return self|Exception
     */
    public function setContext(array $context): self|Exception
    {
        $this->validateArrayContext($context);

        $this->context = $context;

        return $this;
    }

    public function clearContext(): self
    {
        $this->context = [];

        return $this;
    }

    /**
     * @param  string[]  $context
     * @return self|Exception
     */
    public function mergeContext(array $context): self|Exception
    {
        $this->validateArrayContext($context);

        $this->context = array_merge($this->context, $context);

        return $this;
    }

    /**
     * @return self|Exception
     */
    public function validateContext(int $limit = 100): self|Exception
    {
        $this->validateArrayContext($this->context, $limit);

        return $this;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    private function pushContext(string $role, string $input): self
    {
        $this->context[] = [
            'role' => $role,
            'content' => $input,
        ];

        return $this;
    }

    /**
     * @return void|Exception
     */
    private function validateArrayContext(array $array, int $limit = 100)
    {
        if (empty($array)) {
            throw new Exception('Context is empty');
        }

        foreach ($array as $key => $value) {
            if ($limit == $key) {
                break;
            }

            if (array_key_exists('role', $value) && array_key_exists('content', $value)) {
                continue;
            } else {
                throw new Exception('Context is invalid');
            }
        }
    }
}
