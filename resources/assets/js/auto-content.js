import initCkEditor from './ckeditor';
class AutoContent {
    constructor() {
        this.$body = $('body');
        this.promptForm = $('#setup-prompt');
        this.spinForm = $('#setup-spin');
        this.generateModal = $('#auto-content-modal');
        this.spinModal = $('#auto-content-spin-modal');
        this.$body = $('body');

        if ($('#auto-content-modal').length) {
            this.handleGenerateEvents();
        }
        if ($('#auto-content-spin-modal').length) {
            this.handleSpinEvents();
        }
        this.initEditor();
    }

    initEditor() {
        if (document.getElementById('preview_content')) {
            initCkEditor('preview_content');
        }
        if (document.getElementById('preview_spin_content')) {
            initCkEditor('preview_spin_content');
        }
    }

    updateModalState(modal, isLoading) {
        const actionButton = modal.find('.modal-footer .btn:not([data-bs-dismiss])');

        if (isLoading) {
            actionButton.addClass('button-loading').css('pointer-events', 'none');
        } else {
            actionButton.removeClass('button-loading').css('pointer-events', '');
        }
    }

    loadDefaultPrompt(promptUrl) {
        let $self = this;
        let $promptForm = $self.promptForm;

        promptUrl = new URL(promptUrl);
        const entity = promptUrl.searchParams.get('entity');
        const $form = $('form');
        const $except = ['description', 'content', 'uri', 'ip', 'model', "prompt", "target_field", "target_spin_field", "preview_content", "target_spin_field", "spin-template"];
        let $formData = $form.serializeArray();

        $formData.push({ name: 'entity', value: entity });
        $formData = $formData.filter(item => !$except.includes(item.name));

        $.ajax({
            url: promptUrl,
            type: 'POST',
            data: $formData,
            beforeSend: () => {
                $self.updateModalState($self.generateModal, true);
                $promptForm.hide();
            },
            success: res => {
                if (res.error) {
                    Botble.showError(res.message);
                } else {
                    $self.handlePromptField(res.data);
                    // Botble.initResources();
                }
            },
            error: data => {
                $self.updateModalState($self.generateModal, false);
                $promptForm.show();
                Botble.handleError(data);
            },
            complete: () => {
                $self.updateModalState($self.generateModal, false);
                $promptForm.show();
            },
        });
    }

    pushContentToTarget($contentValue, $targetName) {
        if (!$targetName) {
            return;
        }

        $contentValue = $contentValue.replace(/(?:\r\n|\r|\n)/g, '<br>');
        let $contentTarget = $('form').find('[name="' + $targetName + '"]');

        $contentTarget.each(function (index, element) {
            let id = element.id || '';

            if (EDITOR.CKEDITOR[id]) {
                EDITOR.CKEDITOR[id].setData($contentValue)
            } else {
                element.value = $contentValue;
            }
            Botble.showSuccess('Copied content!')
        });
    }

    handleGenerateEvents() {
        let $self = this;
        let $promptForm = $self.promptForm;
        let $previewEditor = $promptForm.find('#preview_content');
        let $targetField = $promptForm.find('#target_field');
        let $promptType = $promptForm.find('#prompt_type');
        let $promptEditor = $promptForm.find('#prompt');

        let $btnOpenGenerate = $('.btn-auto-content-generate');
        let $btnGenerate = $('#generate-content');
        let $btnPush = $('#push-content-to-target');

        const renderPrompt = (index = 0) => {
            if (typeof $promptTemplates !== 'undefined' && $promptTemplates[index]) {
                $promptEditor.val($promptTemplates[index].content);
            }
        }

        $btnOpenGenerate.on('click', function (event) {
            event.preventDefault();
            let $current = $(event.currentTarget);
            let $promptUrl = $current.data('load-form');

            $self.loadDefaultPrompt($promptUrl);
            $self.generateModal.modal('show');
        });

        $promptType.on('change', (e) => {
            renderPrompt($(e.currentTarget).val());
        });

        $btnGenerate.on('click', function (event) {
            event.preventDefault();

            let $current = $(event.currentTarget);
            let $generateUrl = $current.data('generate-url');
            let $promptValue = $promptEditor.val();

            $.ajax({
                url: $generateUrl,
                type: 'POST',
                data: {
                    prompt: $promptValue
                },
                beforeSend: () => {
                    $self.updateModalState($self.generateModal, true);
                },
                success: res => {
                    if (res.error) {
                        Botble.showError(res.message);
                    } else {
                        let editor = window.EDITOR.CKEDITOR[$previewEditor.prop('id')];
                        editor.setData(res.data.content);
                    }
                },
                error: data => {
                    Botble.handleError(data);
                },
                complete: () => {
                    $self.updateModalState($self.generateModal, false);
                },
            });
        });

        $btnPush.on('click', function (event) {
            event.preventDefault();

            let editor = window.EDITOR.CKEDITOR[$previewEditor.prop('id')]
            let $contentValue = editor.getData();
            let $targetName = $targetField.val();

            $self.pushContentToTarget($contentValue, $targetName);
        });

        renderPrompt(0);
    }

    handleSpinEvents() {
        let $self = this;
        let $targetField = $self.spinForm.find('#target_spin_field');

        let $spinTemplateTitle = $self.spinForm.find('#spin_template_title');
        let $spinEditor = $self.spinForm.find('#spin');
        let $previewEditor = $self.spinForm.find('#preview_spin_content');

        let $btnSpin = $('#spin-content');
        let $btnPush = $('#push-spin-content-to-target');
        let $btnOpenSpin = $('.btn-auto-content-spin');
        $self.spinModal.find('.modal-body .loading-spinner').hide();

        const renderSpinTemplate = (index = 0) => {
            if (typeof $spinTemplates !== 'undefined' && $spinTemplates[index]) {
                $spinEditor.val($spinTemplates[index]?.content);
            }
        }

        const pushTargetContentToSpin = ($targetName = '') => {
            let $contentValue = '';
            let $previewId = $previewEditor.prop('id');

            if (!$targetName) {
                return;
            }
            let $contentTarget = $('form').find('[name="' + $targetName + '"]');
            $contentTarget.each(function (index, element) {
                let id = element.id || '';

                if (EDITOR.CKEDITOR[id]) {
                    $contentValue = EDITOR.CKEDITOR[id].getData($contentValue)
                } else {
                    $contentValue = element.value;
                }
            });

            if (EDITOR.CKEDITOR[$previewId]) {
                EDITOR.CKEDITOR[$previewId].setData($contentValue);
            } else {
                $previewEditor.val($contentValue);
            }
        }

        const getSpinTemplate = () => {
            let $spinValue = $spinEditor.val();
            $spinValue = $spinValue.split(/\r?\n/)
                .filter(element => element)
                .map((parents) => {
                    let elements = parents?.slice(1, -1)?.split('|');
                    elements = elements
                        .filter(element => {
                            element = element?.trim();
                            return element.length
                        })
                        .map((element) => {
                            return element?.trim();
                        })
                    return elements;
                });

            return $spinValue;
        }

        $btnOpenSpin.on('click', function (event) {
            event.preventDefault();
            let $targetName = $targetField.val();
            pushTargetContentToSpin($targetName);
            $('#auto-content-spin-modal').modal('show');
        });

        $btnSpin.on('click', function (e) {
            e.preventDefault();
            let $spinValue = getSpinTemplate();
            let $previewValue = $previewEditor.val();
            let $previewId = $previewEditor.prop('id')

            for (const words of $spinValue) {
                for (const item of words) {
                    let regex = new RegExp(item, 'gi');

                    if ($previewValue.match(regex)) {
                        const randomWord = words[Math.floor(Math.random() * words.length)];
                        $previewValue = $previewValue.replace(regex, randomWord);
                    }
                }
            }

            if (EDITOR.CKEDITOR[$previewId]) {
                EDITOR.CKEDITOR[$previewId].setData($previewValue);
            } else {
                $previewEditor.val($previewValue);
            }
        });

        $btnPush.on('click', function (e) {
            e.preventDefault();
            let $contentValue = $previewEditor.val();
            let $targetName = $targetField.val();

            $self.pushContentToTarget($contentValue, $targetName);
        });

        $targetField.on('change', function () {
            let $targetName = $targetField.val();
            pushTargetContentToSpin($targetName);
        });

        $spinTemplateTitle.on('change', function (e) {
            renderSpinTemplate($(this).val());
        });

        renderSpinTemplate();
    }

    handlePromptField($data) {
        const $self = this;
        const $extraField = $('#extra_items');
        const $promptForm = $self.promptForm;

        let $promptEditor = $promptForm.find('#prompt');
        let $extraFieldData = $data.extra_fields;

        if (!$extraFieldData instanceof Object) {
            $extraFieldData = {}
        }
        $extraField.empty();

        for (let key in $extraFieldData) {
            const newOption = $(`<label class="mb-2 me-3 d-inline-block"><input type="checkbox" value="${key}" name="extra_fields[]">${key}</label>`);
            $extraField.append(newOption);
        }

        $extraField.find('input[type="checkbox"]').on('change', function () {
            let $promptTypeVal = $promptForm.find('#prompt_type').val();
            let $promptValue = $promptTemplates[$promptTypeVal]['content'];
            let $clonedPrompt = $promptValue.slice($promptValue); //clone string
            let $extraContent = '';

            $promptEditor.val($promptValue);
            $extraField.find('input:checked').each(function () {
                $extraContent += "\n";
                $extraContent += $extraFieldData[$(this).val()] || '';
            });

            $clonedPrompt += $extraContent;
            $promptEditor.val($clonedPrompt);
        });

    }
}

$(document).ready(() => {
    new AutoContent();
});
