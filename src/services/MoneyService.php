<?php
/**
 * Money plugin for Craft CMS 3.x
 *
 * A money plugin
 *
 * @link      https://newism.com.au
 * @copyright Copyright (c) 2020 Leevi Graham
 */

namespace newism\money\services;

use craft\base\Component;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Parser\DecimalMoneyParser;

/**
 * Money Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Leevi Graham
 * @package   Money
 * @since     0.0.1
 */
class MoneyService extends Component
{
    protected $intlMoneyFormatters = [];
    protected $intlDecimalFormatters = [];
    protected $decimalFormatters = [];
    protected $currencies;

    public function getCurrencies()
    {
        if (empty($this->currencies)) {
            $this->currencies = new ISOCurrencies();
        }

        return $this->currencies;
    }

    public function getCurrencyOptions($preferredCurrencies = [], $excludedCurrencies = []): array
    {
        $preferredOptions = [];
        $options = [];

        $isoCurrencies = require CRAFT_VENDOR_PATH.'/moneyphp/money/resources/currency.php';
        foreach ($isoCurrencies as $code => $currency) {
            $code = $currency['alphabeticCode'];

            if (in_array($code, $excludedCurrencies, true)) {
                continue;
            }

            $fractionDigits = $currency['minorUnit'];
            $name = $currency['currency'];
            $symbol = null;
            $option = [
                'value' => $code,
                'label' => "${code} - ${name}",
                'symbol' => $symbol,
                'fractionDigits' => $fractionDigits,
                'step' => 1 / ((int) '1'.str_repeat('0', $fractionDigits)),
            ];
            $options[$code] = $option;
        }

        ksort($options);

        foreach ($preferredCurrencies as $code) {
            if (array_key_exists($code, $options)) {
                $preferredOptions[$code] = $options[$code];
                unset($options[$code]);
            }
        }

        if (!empty($preferredOptions)) {
            $options = array_merge(
                $preferredOptions,
                [
                    '-' => [
                        'value' => '-1',
                        'label' => '----------',
                        'disabled' => true,
                    ],
                ],
                $options
            );
        }

        return $options;
    }

    public function getIntlFormatter($locale = null): IntlMoneyFormatter
    {
        if (empty($locale)) {
            $locale = \Craft::$app->locale->id;
        }
        if (!array_key_exists($locale, $this->intlMoneyFormatters)) {
            $currencies = $this->getCurrencies();
            $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
            $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
            $this->intlMoneyFormatters[$locale] = $moneyFormatter;
        }

        return $this->intlMoneyFormatters[$locale];
    }

    public function getIntlDecimalFormatter($locale = null): IntlMoneyFormatter
    {
        if (empty($locale)) {
            $locale = \Craft::$app->locale->id;
        }
        if (!array_key_exists($locale, $this->intlDecimalFormatters)) {
            $currencies = $this->getCurrencies();
            $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::DECIMAL);
            $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
            $this->intlDecimalFormatters[$locale] = $moneyFormatter;
        }

        return $this->intlDecimalFormatters[$locale];
    }

    public function getDecimalFormatter($locale = null): DecimalMoneyFormatter
    {
        if (empty($locale)) {
            $locale = \Craft::$app->locale->id;
        }
        if (!array_key_exists($locale, $this->decimalFormatters)) {
            $currencies = $this->getCurrencies();
            $moneyFormatter = new DecimalMoneyFormatter($currencies);
            $this->decimalFormatters[$locale] = $moneyFormatter;
        }

        return $this->decimalFormatters[$locale];
    }

    public function getDecimalParser(): DecimalMoneyParser
    {
        $currencies = $this->getCurrencies();

        return new DecimalMoneyParser($currencies);
    }


}
