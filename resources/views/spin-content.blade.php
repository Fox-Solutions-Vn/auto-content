@php
    $spinTemplate = json_decode(setting('autocontent_spin_template'), true);
    $spinTitle = data_get($spinTemplate, '*.title', []);
@endphp

<form id="setup-spin" action="">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="form-group mb-3">
                {{ Form::label('target_spin_field', trans('plugins/auto-content::content.form.choose_field'), ['class' => 'text-title-field']) }}
                <div class="ui-select-wrapper">
                    {{ Form::select('target_spin_field', $acceptFields, 'content', ['class' => 'ui-select']) }}
                    <svg class="svg-next-icon svg-next-icon-size-16">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                    </svg>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="form-group mb-3">
                {{ Form::label('spin_template_title', trans('plugins/auto-content::content.form.choose_template'), ['class' => 'text-title-field']) }}
                <div class="ui-select-wrapper">
                    {{ Form::select('spin_template_title', $spinTitle, null, ['class' => 'ui-select']) }}
                    <svg class="svg-next-icon svg-next-icon-size-16">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                    </svg>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-6">
            <div class="form-group mb-3">
                {{ Form::textarea('spin-template', null, ['class' => 'next-input', 'rows' => 5, 'placeholder' => trans('plugins/auto-content::content.form.spin_placeholder'), 'id' => 'spin']) }}
            </div>
        </div>
        <div class="col-md-12 col-sm-6">
            <div class="form-group mb-3 preview-wrapper-content">
                {{ Form::editor('preview_content', null, ['placeholder' => trans('plugins/auto-content::content.form.preview_placeholder'), 'id' => 'preview_spin_content']) }}
            </div>
        </div>
    </div>
</form>

<script>
    var $spinTemplates = JSON.parse(@json(setting('autocontent_spin_template') ?? '[]'));

    if (!$spinTemplates.length) {
        $spinTemplates = [];
    }
</script>
