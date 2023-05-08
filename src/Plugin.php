<?php

namespace FoxSolution\AutoContent;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Setting;

class Plugin extends PluginOperationAbstract
{
    public static function activated()
    {
        $settings = [
            'autocontent_proxy_enable' => 0,
            'autocontent_proxy_protocol' => null,
            'autocontent_proxy_ip' => null,
            'autocontent_proxy_port' => null,
            'autocontent_proxy_username' => null,
            'autocontent_proxy_password' => null,
            'autocontent_prompt_template' => '[{"title":"N\u1ed9i dung s\u1ea3n ph\u1ea9m","content":"B\u1ea1n s\u1ebd l\u00e0 m\u1ed9t nh\u00e2n vi\u00ean marketing. T\u00f4i s\u1ebd \u0111\u01b0a c\u00e1c th\u00f4ng tin c\u1ee7a s\u1ea3n ph\u1ea9m, b\u1ea1n s\u1ebd vi\u1ebft m\u1ed9t b\u00e0i vi\u1ebft gi\u1edbi thi\u1ec7u v\u1ec1 s\u1ea3n ph\u1ea9m \u0111\u00f3, b\u00e0i vi\u1ebft y\u00eau c\u1ea7u chu\u1ea9n seo c\u1ee7a google v\u00e0 mang t\u00ednh thuy\u1ebft ph\u1ee5c cao \u0111\u1ec3 t\u0103ng t\u1ec9 l\u1ec7 ng\u01b0\u1eddi d\u00f9ng ch\u1ed1t \u0111\u01a1n h\u00e0ng.\r\nTh\u00f4ng s\u1ed1 s\u1ea3n ph\u1ea9m:"},{"title":"N\u1ed9i dung b\u00e0i vi\u1ebft","content":"B\u1ea1n s\u1ebd l\u00e0 m\u1ed9t nh\u00e2n vi\u00ean marketing. N\u1ed9i dung b\u00e0i vi\u1ebft v\u1ec1:"}]',
            'autocontent_openai_key' => null,
            'autocontent_openai_temperature' => 1,
            'autocontent_openai_frequency_penalty' => 0,
            'autocontent_openai_presence_penalty' => 0,
            'autocontent_openai_models' => '["gpt-3.5-turbo"]',
            'autocontent_openai_default_model' => 'gpt-3.5-turbo',
            'autocontent_spin_template' => '[]',
        ];

        foreach ($settings as $key => $item) {
            Setting::set($key, $item);
        }
        Setting::save();
    }
}
