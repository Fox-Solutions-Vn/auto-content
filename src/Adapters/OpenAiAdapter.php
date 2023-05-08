<?php

declare(strict_types=1);

namespace FoxSolution\AutoContent\Adapters;

use FoxSolution\AutoContent\Contracts\OpenAiInterface;
use FoxSolution\AutoContent\Handlers\ChatResultHandler;
use Orhanerday\OpenAi\OpenAi;

class OpenAiAdapter implements OpenAiInterface
{
    private OpenAi $openai;

    private string $openaiModel;

    public function __construct()
    {
        $this->initInstance();
        $this->setProxy();
        $this->setApiModel(setting('autocontent_openai_default_model'));
    }

    public function initInstance(): self
    {
        $token = (string) setting('autocontent_openai_key', env('OPENAI_API_KEY'));

        if (empty($token)) {
            return $this;
        }

        $this->openai = new OpenAi($token);

        return $this;
    }

    public function setApiModel(string $modelName): self
    {
        $this->openaiModel = $modelName;

        return $this;
    }

    public function setProxy(): self
    {
        if ((bool) setting('autocontent_proxy_enable') && $this->checkInitedOpenAi()) {
            $this->openai->setProxy($this->buildProxy());
        }

        return $this;
    }

    private function buildProxy(): string
    {
        $protocol = (string) setting('autocontent_proxy_protocol');
        $ip = (string) setting('autocontent_proxy_ip');
        $port = (string) setting('autocontent_proxy_port');
        $username = (string) setting('autocontent_proxy_username');
        $password = (string) setting('autocontent_proxy_password');

        $proxy = (! empty($protocol)) ? "{$protocol}://" : 'http://';
        $proxy .= (! empty($username) && ! empty($password)) ? "{$username}:{$password}@" : '';
        $proxy .= (! empty($ip)) ? "{$ip}" : '';
        $proxy .= (! empty($port)) ? ":{$port}" : '';

        return $proxy;
    }

    public function getApiModelList(): array
    {
        $apiModels = json_decode(setting('autocontent_openai_models', '[]'), true) ?? [];
        $apiModels = array_combine($apiModels, $apiModels);

        return $apiModels;
    }

    public function generateContent(string $prompt): string
    {
        set_time_limit(500);

        if (! $this->checkInitedOpenAi()) {
            return '';
        }

        $chatResult = $this->openai->chat($this->prepareChatParams($prompt));
        $chatHandler = new ChatResultHandler($chatResult);

        return $chatHandler->getResultContent();
    }

    private function prepareChatParams(string $prompt): array
    {
        return [
            'model' => $this->openaiModel,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $prompt,
                ],
            ],
            'temperature' => (float) setting('autocontent_openai_temperature', '1.0'),
            'frequency_penalty' => (float) setting('autocontent_openai_frequency_penalty', 0),
            'presence_penalty' => (float) setting('autocontent_openai_presence_penalty', 0),
        ];
    }

    public function checkInitedOpenAi()
    {
        return isset($this->openai);
    }
}
