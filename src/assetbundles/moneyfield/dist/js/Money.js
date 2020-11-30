/**
 * Money plugin for Craft CMS
 *
 * Money Field JS
 *
 * @author    Leevi Graham
 * @copyright Copyright (c) 2020 Leevi Graham
 * @link      https://newism.com.au
 * @package   Money
 * @since     1.0.0MoneyMoney
 */

;(function ($, window, document, undefined) {

    var pluginName = 'MoneyMoney',
        defaults = {};

    // Plugin constructor
    function Plugin (element, options) {
        this.element = element;

        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {

        init: function (id) {
            var _this = this;

            $(function () {
                let currencyEl = $('#'+_this.options.namespace+'-currency', _this.element);
                let amountEl = $('#'+_this.options.namespace+'-amount', _this.element);
                let prefixEl = $('.prefix', _this.element);
                let suffixEl = $('.suffix', _this.element);

                currencyEl.on('change', function () {
                    let currencyCode = this.value;
                    if (!currencyCode) {
                        prefixEl.text('').hide();
                        suffixEl.text('').hide();
                        return;
                    }
                    let currencySymbol = _this.getCurrencySymbol(
                        _this.options.locale,
                        currencyCode,
                    );
                    if(currencySymbol.position === 'prefix') {
                        prefixEl.text(currencySymbol.currencySymbol).show();
                        suffixEl.text('').hide();
                    }
                    if(currencySymbol.position === 'suffix') {
                        prefixEl.text('').hide();
                        suffixEl.text(currencySymbol.currencySymbol).show();
                    }
                    let step = _this.options.currencyOptions[currencyCode]['step'];
                    let fractionDigits = _this.options.currencyOptions[currencyCode]['fractionDigits'];
                    let value = parseFloat(amountEl.val()).toFixed(fractionDigits);
                    amountEl.attr('step', step).attr('value', value).val(value);
                }).trigger('change');
            });
        },
        getCurrencySymbol: function (locale, currency) {
            let testString = (0).toLocaleString(locale, {
                style: 'currency',
                currency,
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            }).trim();
            let position = testString[0] === '0' ? 'suffix' : 'prefix';
            let currencySymbol = testString.replace(/\d+/, '', testString).trim();
            return {
                position: position,
                currencySymbol: currencySymbol
            }
        },
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName,
                    new Plugin(this, options));
            }
        });
    };

})(jQuery, window, document);
