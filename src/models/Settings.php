<?php

namespace newism\money\models;

use craft\base\Model;

class Settings extends Model
{
    public $preferredCurrencies = '';
    public $excludedCurrencies = '';

    public function rules()
    {
        return [
            ['preferredCurrencies', 'string'],
            ['preferredCurrencies', 'default', 'value' => ''],
            ['excludedCurrencies', 'string'],
            ['excludedCurrencies', 'default', 'value' => ''],
        ];
    }
}
