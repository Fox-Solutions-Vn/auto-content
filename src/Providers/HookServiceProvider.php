<?php

namespace FoxSolution\AutoContent\Providers;

use Assets;
use BaseHelper;
use Botble\Base\Forms\FormAbstract;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(BASE_FILTER_BEFORE_RENDER_FORM, [$this, 'registerForm'], 30, 2);
    }

    public function registerForm(FormAbstract $form, $data): FormAbstract
    {
        Assets::addScriptsDirectly(config('core.base.general.editor.'.BaseHelper::getRichEditor().'.js'))
            ->addScriptsDirectly('vendor/core/core/base/js/editor.js')
            ->addScriptsDirectly('/vendor/core/plugins/auto-content/js/auto-content.js');

        $entityType = $this->getDataType(get_class($data));
        if (empty($entityType)) {
            return $form;
        }

        $allFields = $form->getFields();
        $appendPosition = $this->getAppendPosition($allFields);

        $form->addBefore($appendPosition, 'autocontent', 'html', [
            'label' => trans('plugins/auto-content::content.form.title'),
            'label_attr' => ['class' => 'control-label'],
            'choices' => [],
            'value' => [],
            'data' => [
                'formData' => $data,
                'entityType' => $entityType,
                'acceptFields' => $this->getAcceptFields($form),
                'allFields' => $allFields,
            ],
            'template' => 'plugins/auto-content::partials.action',
        ]);

        return $form;
    }

    private function getAppendPosition(array $allFields): string
    {
        if (isset($allFields['categories[]'])) {
            return 'categories[]';
        }

        return array_key_last($allFields);
    }

    private function getDataType($entityClass): string
    {
        $entitySupported = apply_filters(AUTOCONTENT_ACTION_ADD_ENTITY_TYPE, [
            'Botble\Ecommerce\Models\Product' => 'product',
            'Botble\Blog\Models\Post' => 'post',
        ]);

        return data_get($entitySupported, $entityClass, '');
    }

    private function getAcceptFields($form): array
    {
        $formFields = [];
        $acceptType = ['textarea', 'editor'];

        foreach ($form->getFields() as $key => $field) {
            $fieldName = $field->getRealName();
            $filedType = $field->getType();
            $options = $field->getOptions();
            $placeholder = data_get($options, 'label', $fieldName);

            if (in_array($filedType, $acceptType)) {
                $formFields[$fieldName] = $placeholder;
            }
        }

        return $formFields;
    }
}
