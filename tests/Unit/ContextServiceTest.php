<?php

namespace VdsEngineer\GigaGptIntegration\Tests\Unit;

use PHPUnit\Framework\TestCase;
use VdsEngineer\GigaGptIntegration\Services\ContextService;

class ContextServiceTest extends TestCase
{
    public function testGetUserContextAndValidate(): void
    {
        $ContextService = new ContextService;
        $context = $ContextService->getContext();
        $this->assertIsArray($context);
        $this->assertCount(0, $context);

        try {
            $ContextService->validateContext();
            $this->fail('This test should fail');
        } catch (\Throwable $th) {
        }

        $ContextService->pushContextUser('Hi world');
        $ContextService->validateContext();
    }

    public function testAddContext(): void
    {
        $ContextService = new ContextService;
        $ContextService->pushContextUser('Hi world');
        $context = $ContextService->getContext();
        $this->assertIsArray($context);
        $this->assertCount(1, $context);
        $this->assertEquals('Hi world', $context[0]['content']);
        $this->assertEquals('user', $context[0]['role']);

        $ContextService->pushContextSystem('Hello system');
        $context = $ContextService->getContext();
        $this->assertCount(2, $context);
        $this->assertEquals('Hello system', $context[1]['content']);
        $this->assertEquals('system', $context[1]['role']);

        $ContextService->pushContextAssistant('Hello assistant');
        $context = $ContextService->getContext();
        $this->assertCount(3, $context);
        $this->assertEquals('Hello assistant', $context[2]['content']);
        $this->assertEquals('assistant', $context[2]['role']);
    }

    public function testMergeContext(): void
    {
        $ContextService = new ContextService;
        $context = $ContextService->pushContextUser('Hi world')
            ->pushContextSystem('Hello system')
            ->pushContextAssistant('Hello assistant')
            ->getContext();

        $context[] = [
            'role' => 'user',
            'content' => 'Hi again',
        ];

        $contextTest = array_merge($ContextService->getContext(), $context);

        $contextMerged = $ContextService->mergeContext($context)->getContext();

        foreach ($contextMerged as $key => $value) {
            $this->assertEquals($value['content'], $contextTest[$key]['content']);
            $this->assertEquals($value['role'], $contextTest[$key]['role']);
        }
    }

    public function testSetContext(): void
    {
        $ContextService = new ContextService;
        $context = [];

        $context[] = [
            'role' => 'user',
            'content' => 'Hi world',
        ];

        $ContextService->setContext($context);

        $context = $ContextService->getContext();
        $this->assertIsArray($context);
        $this->assertCount(1, $context);
        $this->assertEquals('Hi world', $context[0]['content']);
        $this->assertEquals('user', $context[0]['role']);
    }

    public function testClearContext(): void
    {
        $ContextService = new ContextService;
        $ContextService->pushContextUser('Hi world')
            ->pushContextSystem('Hello system')
            ->pushContextAssistant('Hello assistant')->clearContext();

        $context = $ContextService->getContext();

        $this->assertIsArray($context);
        $this->assertCount(0, $context);
    }
}
