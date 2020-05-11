<?php
/**
 * Money plugin for Craft CMS 3.x
 *
 * Money plugin to connect users / site to the Money Basic API
 *
 * @link      https://newism.com.au
 * @copyright Copyright (c) 2020 Leevi Graham
 */

/**
 * Money config.php
 *
 * This file exists only as a template for the Money settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'config' as 'money.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [
    # Enter a comma delimited list of alphabetical currency codes. See: https://github.com/moneyphp/money/blob/master/resources/currency.php
    'preferredCurrencies' => '',

    # Enter a comma delimited list of alphabetical currency codes. See: https://github.com/moneyphp/money/blob/master/resources/currency.php
    'excludedCurrencies' => '',
];
