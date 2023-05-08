<?php

namespace FoxSolution\AutoContent\Actions\Traits;

use FoxSolution\AutoContent\Http\Requests\GenerateRequest;
use FoxSolution\AutoContent\Http\Requests\PromptRequest;
use FoxSolution\AutoContent\Supports\AutoContentSupport;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Http\Request;
use OpenAi;

/**
 * @property Request $request
 * @property BaseHttpResponse $response
 */
trait AutoContentGenerate
{
    public function generatePrompt(PromptRequest $request)
    {
        $entityType = $request->get('entity');
        $optionText = [];

        $fieldsData = [
            'product' => AutoContentSupport::getDataFromFieldForProduct($this->request),
        ];

        $fieldsData = apply_filters(AUTOCONTENT_FILTER_ADD_SUPPORT_FIELDS, $fieldsData);
        $optionText = data_get($fieldsData, $entityType);

        return $this->response->setData([
            'extra_fields' => $optionText,
        ]);
    }

    public function generate(GenerateRequest $request)
    {
        $prompt = $request->get('prompt');
        $apiModel = setting('autocontent_openai_default_model');

        if (! OpenAi::checkInitedOpenAi()) {
            return $this->response
                ->setError(true)
                ->setMessage(trans('plugins/auto-content::content.error.OpenAi not initialized'));
        }

        $prompt = trans('plugins/auto-content::content.form.request_output_format')."\n".$prompt;

        OpenAi::setApiModel($apiModel);
        $result = OpenAi::generateContent($prompt);

        return $this->response
            ->setData(['content' => $result]);
    }
}
