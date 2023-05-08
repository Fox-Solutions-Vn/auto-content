@php
    $formData = $options['data']['formData'];
    $entityType = $options['data']['entityType'];
    $acceptFields = $options['data']['acceptFields'];
    $allFields = array_keys($options['data']['allFields']);
@endphp

<button type="button" class="btn btn-primary btn-auto-content btn-auto-content-generate"
    data-load-form="{{ route('auto-content.generate-prompt', ['entity' => $entityType]) }}">{{ trans('plugins/auto-content::content.generate') }}</button>
<button type="button" class="btn btn-primary btn-auto-content btn-auto-content-spin">{{ trans('plugins/auto-content::content.spin') }}</button>

@pushOnce('footer')
    <div id="auto-content-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title"><i
                            class="til_img"></i><strong>{{ trans('plugins/auto-content::content.form.title') }}</strong>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>

                <div class="modal-body with-padding">
                    @include('plugins/auto-content::generate-content')
                </div>

                <div class="modal-footer">
                    <button type="button" class="float-start btn btn-warning"
                        data-bs-dismiss="modal">{{ trans('core/base::tables.cancel') }}</button>
                    <a class="float-end btn btn-info" id="generate-content"
                        data-generate-url="{{ route('auto-content.generate') }}"
                        href="">{{ trans('plugins/auto-content::content.form.generate') }}</a>
                    <a class="float-end btn btn-success" id="push-content-to-target"
                        href="">{{ trans('plugins/auto-content::content.form.push') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div id="auto-content-spin-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title"><i
                            class="til_img"></i><strong>{{ trans('plugins/auto-content::content.form.title') }}</strong>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>

                <div class="modal-body with-padding">
                    @include('plugins/auto-content::spin-content')
                </div>

                <div class="modal-footer">
                    <button type="button" class="float-start btn btn-warning"
                        data-bs-dismiss="modal">{{ trans('core/base::tables.cancel') }}</button>
                    <a class="float-end btn btn-info" id="spin-content"
                        href="">{{ trans('plugins/auto-content::content.form.spin') }}</a>
                    <a class="float-end btn btn-success" id="push-spin-content-to-target"
                        href="">{{ trans('plugins/auto-content::content.form.push') }}</a>
                </div>
            </div>
        </div>
    </div>
@endPushOnce
