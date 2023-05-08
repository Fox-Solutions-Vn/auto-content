@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    {!! Form::open(['route' => ['auto-content.setting.edit']]) !!}
    <div class="max-width-1200">
        <div class="flexbox-annotated-section">
            <div class="flexbox-annotated-section-annotation">
                <div class="annotated-section-title pd-all-20">
                    <h2>{{ trans('plugins/auto-content::content.setting.generate') }}</h2>
                </div>
                <div class="annotated-section-description pd-all-20 p-none-t">
                    <p class="color-note">{{ trans('plugins/auto-content::content.setting.generate_description') }}</p>
                </div>
            </div>

            <div class="flexbox-annotated-section-content">
                <div class="wrapper-content pd-all-20">
                    <div class="form-group mb-3">
                        <label>{{ trans('plugins/auto-content::content.setting.openai_key') }}</label>
                        <input type="password" placeholder="**********" name="autocontent_openai_key" class="next-input"
                            value="{{ old('autocontent_openai_key', setting('autocontent_openai_key')) }}" />
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-title-field"
                            for="autocontent_openai_temperature">{{ trans('plugins/auto-content::content.setting.openai_temperature') }}
                        </label>
                        {!! Form::text('autocontent_openai_temperature', setting('autocontent_openai_temperature'), [
                            'placeholder' => trans('plugins/auto-content::content.setting.openai_temperature'),
                            'class' => 'next-input',
                        ]) !!}
                    </div>
                    {{-- <div class="form-group mb-3">
                        <label class="text-title-field"
                            for="autocontent_openai_max_tokens">{{ trans('plugins/auto-content::content.setting.openai_max_tokens') }}
                        </label>
                        {!! Form::text('autocontent_openai_max_tokens', setting('autocontent_openai_max_tokens'), [
                            'placeholder' => trans('plugins/auto-content::content.setting.openai_max_tokens'),
                            'class' => 'next-input',
                        ]) !!}
                    </div> --}}
                    <div class="form-group mb-3">
                        <label class="text-title-field"
                            for="autocontent_openai_frequency_penalty">{{ trans('plugins/auto-content::content.setting.openai_frequency_penalty') }}
                        </label>
                        {!! Form::text('autocontent_openai_frequency_penalty', setting('autocontent_openai_frequency_penalty'), [
                            'placeholder' => trans('plugins/auto-content::content.setting.openai_frequency_penalty'),
                            'class' => 'next-input',
                        ]) !!}
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-title-field"
                            for="autocontent_openai_presence_penalty">{{ trans('plugins/auto-content::content.setting.openai_presence_penalty') }}
                        </label>
                        {!! Form::text('autocontent_openai_presence_penalty', setting('autocontent_openai_presence_penalty'), [
                            'placeholder' => trans('plugins/auto-content::content.setting.openai_presence_penalty'),
                            'class' => 'next-input',
                        ]) !!}
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-title-field"
                            for="autocontent_openai_models">{{ trans('plugins/auto-content::content.setting.openai_model') }}
                        </label>
                        <div class="form-group mb-3" id="openai-model-wrapper"
                            data-models="{{ setting('autocontent_openai_models') }}"
                            data-default="{{ setting('autocontent_openai_default_model') }}">
                            <a id="add-model" class="link" data-placeholder=""><small>+
                                    {{ trans('plugins/auto-content::content.setting.add_more') }}</small></a>
                        </div>
                        <div class="help-ts">
                            <i class="fa fa-info-circle"></i>
                            <a href="https://platform.openai.com/docs/models/model-endpoint-compatibility"
                                target="_blank">{{ trans('plugins/auto-content::content.setting.see_documention') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flexbox-annotated-section template-wrapper" id="prompt-template-wrapper">
            <div class="flexbox-annotated-section-annotation">
                <div class="annotated-section-title pd-all-20">
                    <h2>{{ trans('plugins/auto-content::content.setting.generate_default') }}</h2>
                </div>
            </div>

            <div class="flexbox-annotated-section-content">
                <div class="wrapper-content pd-all-20">
                    <a class="link add-template" href=""><small>
                            + {{ trans('plugins/auto-content::content.setting.add_more') }}</small>
                    </a>
                </div>
            </div>
        </div>

        <div class="flexbox-annotated-section">
            <div class="flexbox-annotated-section-annotation">
                <div class="annotated-section-title pd-all-20">
                    <h2>{{ trans('plugins/auto-content::content.setting.proxy') }}</h2>
                </div>
                <div class="annotated-section-description pd-all-20 p-none-t">
                    <p class="color-note">{{ trans('plugins/auto-content::content.setting.proxy_description') }}</p>
                </div>
            </div>

            <div class="flexbox-annotated-section-content">
                <div class="wrapper-content pd-all-20">
                    <div class="form-group mb-3">
                        <label class="text-title-field"
                            for="autocontent_proxy_enable">{{ trans('plugins/auto-content::content.setting.proxy_enable') }}
                        </label>
                        <label class="me-2">
                            <input type="radio" name="autocontent_proxy_enable" class="setting-selection-option"
                                data-target="#autocontent-proxy-settings" value="1"
                                @if (setting('autocontent_proxy_enable')) checked @endif>{{ trans('core/setting::setting.general.yes') }}
                        </label>
                        <label>
                            <input type="radio" name="autocontent_proxy_enable" class="setting-selection-option"
                                data-target="#autocontent-proxy-settings" value="0"
                                @if (!setting('autocontent_proxy_enable')) checked @endif>{{ trans('core/setting::setting.general.no') }}
                        </label>
                    </div>

                    <div id="autocontent-proxy-settings"
                        class="mb-4 border rounded-top rounded-bottom p-3 bg-light @if (!setting('autocontent_proxy_enable')) d-none @endif">
                        <div class="form-group mb-3">
                            <label>{{ trans('plugins/auto-content::content.setting.proxy_protocol') }} </label>
                            <div class="ui-select-wrapper">
                                {!! Form::select(
                                    'autocontent_proxy_protocol',
                                    ['0' => 'http', '1' => 'https'],
                                    setting('autocontent_proxy_protocol'),
                                    ['class' => 'ui-select', 'id' => 'autocontent_proxy_protocol'],
                                ) !!}
                                <svg class="svg-next-icon svg-next-icon-size-16">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                                </svg>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label>{{ trans('plugins/auto-content::content.setting.proxy_ip') }}</label>
                            {!! Form::text('autocontent_proxy_ip', setting('autocontent_proxy_ip'), [
                                'placeholder' => '192.168.1.1',
                                'class' => 'next-input',
                            ]) !!}
                        </div>
                        <div class="form-group mb-3">
                            <label>{{ trans('plugins/auto-content::content.setting.proxy_port') }}</label>
                            {!! Form::text('autocontent_proxy_port', setting('autocontent_proxy_port'), [
                                'placeholder' => '3304',
                                'class' => 'next-input',
                            ]) !!}
                        </div>
                        <div class="form-group mb-3">
                            <label>{{ trans('plugins/auto-content::content.setting.proxy_username') }}</label>
                            {!! Form::text('autocontent_proxy_username', setting('autocontent_proxy_username'), [
                                'placeholder' => 'username',
                                'class' => 'next-input',
                            ]) !!}
                        </div>
                        <div class="form-group mb-3">
                            <label>{{ trans('plugins/auto-content::content.setting.proxy_password') }}</label>
                            <input type="password" placeholder="**********" name="autocontent_proxy_password"
                                class="next-input"
                                value="{{ old('autocontent_proxy_password', setting('autocontent_proxy_password')) }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="flexbox-annotated-section" id="spin-template-wrapper">
            <div class="flexbox-annotated-section-annotation">
                <div class="annotated-section-title pd-all-20">
                    <h2>{{ trans('plugins/auto-content::content.setting.spin') }}</h2>
                </div>
                <div class="annotated-section-description pd-all-20 p-none-t">
                    <p class="color-note">{{ trans('plugins/auto-content::content.setting.spin_description') }}</p>
                </div>
            </div>

            <div class="flexbox-annotated-section-content">
                <div class="wrapper-content pd-all-20">
                    <a class="link add-template" data-placeholder=""><small>
                            + {{ trans('plugins/auto-content::content.setting.add_more') }}</small></a>
                </div>
            </div>
        </div>
        <div class="flexbox-annotated-section" style="border: none">
            <div class="flexbox-annotated-section-annotation">
                &nbsp;
            </div>
            <div class="flexbox-annotated-section-content">
                <button class="btn btn-info" type="submit">{{ trans('core/setting::setting.save_settings') }}</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


    <script>
        @php
            $templateJson = setting('autocontent_spin_template') ?: '[]';
            $promptJson = setting('autocontent_prompt_template') ?: '[]';
        @endphp

        var $spinTemplates = [];
        var $promptTemplates = [];
        try {
            $spinTemplates = JSON.parse(@json($templateJson));
        } catch (error) {
            $spinTemplates = [];
        }
        try {
            $promptTemplates = JSON.parse(@json($promptJson));
        } catch (error) {
            $promptTemplates = [];
        }
    </script>

    <template id="spin-html-template">
        <div class="mb-4 border rounded-top rounded-bottom p-3 bg-light more-template">
            <div class="form-group mb-3">
                <label class="text-title-field">
                    {{ trans('plugins/auto-content::content.setting.spin_template_title') }}
                    <a class="btn btn-link text-danger remove-template"><i class="fas fa-minus"></i></a>
                </label>
                {!! Form::text('autocontent_spin_template[][title]', null, [
                    'placeholder' => trans('plugins/auto-content::content.setting.spin_template_title'),
                    'class' => 'next-input item-title',
                ]) !!}
            </div>
            <div class="form-group mb-3">
                <label class="text-title-field">{{ trans('plugins/auto-content::content.setting.spin_label') }}
                </label>
                {!! Form::textarea('autocontent_spin_template[][content]', null, [
                    'placeholder' => trans('plugins/auto-content::content.setting.spin_example'),
                    'class' => 'next-input item-content',
                ]) !!}
            </div>
        </div>
    </template>

    <template id="prompt-html-template">
        <div class="mb-4 border rounded-top rounded-bottom p-3 bg-light more-template">
            <div class="form-group mb-3">
                <label class="text-title-field">
                    {{ trans('plugins/auto-content::content.setting.generate_label') }}
                    <a class="btn btn-link text-danger remove-template"><i class="fas fa-minus"></i></a>
                </label>
                {!! Form::text('autocontent_prompt_template[][title]', null, [
                    'placeholder' => trans('plugins/auto-content::content.setting.generate_label'),
                    'class' => 'next-input item-title',
                ]) !!}
            </div>
            <div class="form-group mb-3">
                <label class="text-title-field">{{ trans('plugins/auto-content::content.setting.generate_content') }}
                </label>
                {!! Form::textarea('autocontent_prompt_template[][content]', null, [
                    'placeholder' => trans('plugins/auto-content::content.setting.generate_content'),
                    'class' => 'next-input item-content',
                ]) !!}
            </div>
        </div>
    </template>
@endsection
