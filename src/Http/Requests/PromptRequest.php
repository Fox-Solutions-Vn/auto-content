<?php

namespace FoxSolution\AutoContent\Http\Requests;

use Botble\Setting\Http\Requests\SettingRequest as BaseRequest;

class PromptRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'entity' => 'required|string',
        ];
    }
}
