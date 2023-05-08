<?php

namespace FoxSolution\AutoContent\Handlers;

use Exception;

class ChatResultHandler
{
    private array $chatResult;

    private string $resultContent;

    private string $finishReason;

    public function __construct(string $chatResult)
    {
        $this->chatResult = json_decode($chatResult, true);
        $this->handleChatResult();
    }

    private function handleChatResult(): void
    {
        if (data_get($this->chatResult, 'error')) {
            throw new Exception(data_get($this->chatResult, 'error.message'));
        }

        $this->resultContent = data_get($this->chatResult, 'choices.0.message.content');
        $this->finishReason = data_get($this->chatResult, 'choices.0.finish_reason');

        if ($this->finishReason != 'stop') {
            throw new Exception(trans('plugins/auto-content::content.error.Incomplete returned content'));
        }

        if ($this->resultContent && $this->finishReason != 'stop') {
            throw new Exception(trans('plugins/auto-content::content.error.An error occurred while processing the api'));
        }
    }

    public function getResultContent(): string
    {
        return $this->resultContent;
    }
}
