<?php

namespace FoxSolution\AutoContent\Http\Requests;

use Botble\Setting\Http\Requests\SettingRequest as BaseRequest;

class SettingRequest extends BaseRequest
{
    public function rules(): array
    {
        $models = implode(',', request('autocontent_openai_models', []));

        return [
            'autocontent_openai_key' => 'string|nullable',
            'autocontent_openai_temperature' => 'required|numeric|min:0|max:2',
            // 'autocontent_openai_max_tokens' => 'required|numeric|min:100',
            'autocontent_openai_frequency_penalty' => 'required|numeric|min:-2|max:2',
            'autocontent_openai_presence_penalty' => 'required|numeric|min:-2|max:2',
            'autocontent_openai_models' => 'required|array',
            'autocontent_openai_models.*' => 'required|string',
            'autocontent_openai_default_model' => 'required|string|in:'.$models,
            'autocontent_prompt_template' => 'array|nullable',
            'autocontent_prompt_template.*.title' => 'string|nullable',
            'autocontent_prompt_template.*.content' => 'string|nullable',
            'autocontent_proxy_enable' => 'boolean',
            'autocontent_proxy_protocol' => 'required_if:autocontent_proxy_enable,1|boolean',
            'autocontent_proxy_ip' => 'required_if:autocontent_proxy_enable,1|ip|nullable',
            'autocontent_proxy_port' => 'required_if:autocontent_proxy_enable,1|numeric|min:0|max:65536|nullable',
            'autocontent_proxy_username' => 'string|nullable',
            'autocontent_proxy_password' => 'string|nullable',
            'autocontent_spin_template' => 'array|nullable',
            'autocontent_spin_template.*.title' => 'string|nullable',
            'autocontent_spin_template.*.content' => 'string|nullable',
        ];
    }
}
