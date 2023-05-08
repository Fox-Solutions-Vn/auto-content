<?php

return [
    'name' => 'Auto Content',
    'generate' => 'Generate content',
    'spin' => 'Spin content',
    'menu' => 'Auto Content',
    'setting' => [
        'page-title' => 'AutoContent settings',
        'generate' => 'AutoContent',
        'generate_description' => 'AutoContent prompt parammeter setting',
        'generate_placeholder' => 'Default prompt........',
        'generate_label' => 'Default prompt',
        'generate_default' => 'Default prompt',
        'generate_label' => 'Prompt title',
        'generate_content' => 'Prompt content',
        'openai_key' => 'Api key',
        'openai_model' => 'Api Models',
        'openai_temperature' => 'Temperature',
        'openai_max_tokens' => 'Max tokens',
        'openai_frequency_penalty' => 'Frequency penalty',
        'openai_presence_penalty' => 'Presence penalty',
        'proxy' => 'Setup AutoContent proxy',
        'proxy_enable' => 'Do you want to use proxy when calling Chatgpt api?',
        'proxy_description' => 'Configure proxy to connect to Chatgpt api.',
        'proxy_protocol' => 'Proxy protocol',
        'proxy_username' => 'Proxy username',
        'proxy_password' => 'Proxy password',
        'proxy_ip' => 'Proxy server ip',
        'proxy_port' => 'Proxy port',
        'spin' => 'Setting Spin',
        'spin_description' => 'Setting spin template',
        'spin_template_title' => 'Spin template title',
        'spin_label' => 'Spin template',
        'spin_example' => "{Dứa|Thơm|Khóm}\n{Hoa|Bông|Đóa hoa|Hoa tươi}",
        'add_more' => 'Add more',
        'see_documention' => 'See documention',
    ],
    'form' => [
        'title' => 'Auto Content',
        'generate' => 'Generate content',
        'spin' => 'Spin content',
        'push' => 'Push content',
        'choose_field' => 'Choose form field',
        'choose_template' => 'Choose spin template',
        'api_model' => 'Api model',
        'prompt_type' => 'Prompt type',
        'prompt_label' => 'Prompt message',
        'prompt_placeholder' => 'Prompt message....',
        'preview_label' => 'Preview content',
        'preview_placeholder' => 'Preview content',
        'spin_placeholder' => 'Spin template',
        'extra_field' => 'Extra data',
        'request_output_format' => 'Presented in html for WYSIWYG editors.',
    ],
    'error' => [
        'Incomplete returned content' => 'Incomplete returned content',
        'An error occurred while processing the api' => 'An error occurred while processing the api',
        'OpenAi not initialized' => 'OpenAi not initialized',
    ],
];
