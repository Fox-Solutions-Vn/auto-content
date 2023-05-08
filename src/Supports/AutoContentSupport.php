<?php

namespace FoxSolution\AutoContent\Supports;

use Illuminate\Http\Request;

class AutoContentSupport
{
    public static function getDataFromFieldForProduct(Request $request)
    {
        $data = $request->only(['name', 'options']);
        $data['options'] = isset($data['options'])
            && is_array($data['options']) ? $data['options'] : [];
        $options = [];

        foreach ($data['options'] as $option) {
            $optionValue = implode('|', data_get($option, 'values.*.option_value'));
            $optionValue = $option['name'].': '.$optionValue;
            $options[] = $optionValue;
        }
        $data['options'] = implode("\n", $options);

        return $data;
    }
}
