<?php

namespace FoxSolution\AutoContent\Actions\Traits;

use Assets;
use FoxSolution\AutoContent\Http\Requests\SettingRequest;
use Botble\Base\Http\Responses\BaseHttpResponse;

trait AutoContentSettings
{
    public function settings()
    {
        page_title()->setTitle(trans('plugins/auto-content::content.setting.page-title'));

        Assets::addScriptsDirectly([
            'vendor/core/core/setting/js/setting.js',
            'vendor/core/plugins/auto-content/js/settings.js',
        ])
            ->addStylesDirectly('vendor/core/core/setting/css/setting.css');

        return view('plugins/auto-content::settings.index');
    }

    public function postEdit(SettingRequest $request, BaseHttpResponse $response)
    {
        $this->saveSettings(
            $request->only([
                'autocontent_openai_key',
                'autocontent_openai_temperature',
                // 'autocontent_openai_max_tokens',
                'autocontent_openai_frequency_penalty',
                'autocontent_openai_presence_penalty',
                'autocontent_openai_models',
                'autocontent_openai_default_model',
                'autocontent_prompt_template',
                'autocontent_proxy_enable',
                'autocontent_proxy_protocol',
                'autocontent_proxy_ip',
                'autocontent_proxy_port',
                'autocontent_proxy_username',
                'autocontent_proxy_password',
                'autocontent_spin_template',
            ])
        );

        return $response
            ->setPreviousUrl(route('settings.options'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    protected function saveSettings(array $data): void
    {
        foreach ($data as $settingKey => $settingValue) {
            if (
                $settingKey == 'autocontent_spin_template'
                || $settingKey == 'autocontent_prompt_template'
            ) {
                $settingValue = array_values($settingValue);
            }

            if (is_array($settingValue)) {
                $settingValue = json_encode(array_filter($settingValue));
            }

            setting()->set($settingKey, (string) $settingValue);
        }

        setting()->save();
    }
}
