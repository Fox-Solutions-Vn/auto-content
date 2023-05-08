class SettingManagement {
    constructor() {
        this.$modelWrapper = $('#openai-model-wrapper');
        this.$spinTemplateWrapper = $('#spin-template-wrapper');
        this.$promptTemplateWrapper = $('#prompt-template-wrapper');

        if (this.$modelWrapper.length) {
            this.handleMultipleModels();
        }

        if (this.$spinTemplateWrapper.length && Array.isArray($spinTemplates)) {
            this.handleMultiSpinTemplate();
        }

        if (this.$promptTemplateWrapper.length && Array.isArray($promptTemplates)) {
            this.handleMultiPromptTemplate();
        }
    }

    handleMultipleModels() {
        const $addBtn = this.$modelWrapper.find('#add-model');
        const $defaultModels = this.$modelWrapper.data('default');
        let $apiModels = this.$modelWrapper.data('models');

        if (!$apiModels.length) {
            $apiModels = [''];
        }

        const addModel = (value = '') => {
            const $newModel = $(`<div class="d-flex mt-2 more-model align-items-center">
          <input type="radio" name="autocontent_openai_default_model" class="setting-selection-option default-model" value="${value}" ${value === $defaultModels ? 'checked' : ''}>
          <input class="next-input item-model" placeholder="${$addBtn.data('placeholder')}" name="autocontent_openai_models[]" value="${value}" />
          <a class="btn btn-link text-danger"><i class="fas fa-minus"></i></a>
        </div>`);

            $addBtn.before($newModel);
        };

        const render = () => {
            $apiModels.forEach(model => {
                addModel(model);
            });
        };

        this.$modelWrapper.on('click', '.more-model > a', function () {
            $(this).parents('.more-model').remove();
            const $models = $('.more-model');
            if (!$models.length) {
                addModel();
            }
        });

        this.$modelWrapper.on('change', '.more-model > input.item-model', function () {
            const value = $(this).val();
            $(this).siblings('.default-model').val(value);
        });

        $addBtn.on('click', e => {
            e.preventDefault();
            addModel();
        });

        render();
    }

    handleMultiSpinTemplate() {
        this.handleMultiTemplate('spin');
    }

    handleMultiPromptTemplate() {
        this.handleMultiTemplate('prompt');
    }

    handleMultiTemplate(templateType) {
        const $self = this;
        const $templateWrapper = templateType === 'spin' ? this.$spinTemplateWrapper : this.$promptTemplateWrapper;
        const $addBtn = $templateWrapper.find('.add-template');
        const $template = $(templateType === 'spin' ? '#spin-html-template' : '#prompt-html-template').get(0);
        let index = 0;

        const addTemplate = (title = '', content = '') => {
            const $newItem = $($template.innerHTML);
            $newItem.find('.item-title')
                .attr('name', `autocontent_${templateType}_template[${index}][title]`)
                .val(title);
            $newItem.find('.item-content')
                .attr('name', `autocontent_${templateType}_template[${index}][content]`)
                .val(content);

            index++;
            $addBtn.before($newItem);
        };

        const render = () => {
            const $templates = templateType === 'spin' ? $spinTemplates : $promptTemplates;
            $templates.forEach(({ title, content }) => {
                addTemplate(title, content);
            });
        };

        $templateWrapper.on('click', '.more-template .remove-template', function (e) {
            e.preventDefault();
            $(this).parents('.more-template').remove();

            const $templates = $templateWrapper.find('.more-template');
            if (!$templates.length) {
                addTemplate();
            }
        });

        $addBtn.on('click', e => {
            e.preventDefault();
            addTemplate();
        });

        render();
    }
}

$(document).ready(() => {
    new SettingManagement();
});
