<?php
/**
 * Money plugin for Craft CMS 3.x
 *
 * Money Fieldtype for CraftCMS v3
 *
 * @link      https://newism.com.au
 * @copyright Copyright (c) 2020 Leevi Graham
 */

namespace newism\money\assetbundles\moneyfield;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * MoneyFieldAsset AssetBundle
 *
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 *
 * Each asset bundle has a unique name that globally identifies it among all asset bundles used in an application.
 * The name is the [fully qualified class name](http://php.net/manual/en/language.namespaces.rules.php)
 * of the class representing it.
 *
 * An asset bundle can depend on other asset bundles. When registering an asset bundle
 * with a view, all its dependent asset bundles will be automatically registered.
 *
 * http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
 *
 * @author    Leevi Graham
 * @package   Money
 * @since     1.0.0
 */
class MoneyFieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * Initializes the bundle.
     */
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = "@newism/money/assetbundles/moneyfield/dist";

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'js/Money.js',
        ];

        $this->css = [
//            'css/Money.css',
        ];

        parent::init();
    }
}
