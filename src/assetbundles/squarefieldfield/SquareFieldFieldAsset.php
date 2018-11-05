<?php
/**
 * Square plugin for Craft CMS 3.x
 *
 * Test
 *
 * @link      https://trendyminds.com
 * @copyright Copyright (c) 2018 TrendyMinds
 */

namespace trendyminds\square\assetbundles\squarefieldfield;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * SquareFieldFieldAsset AssetBundle
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
 * @author    TrendyMinds
 * @package   Square
 * @since     1.0.0
 */
class SquareFieldFieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * Initializes the bundle.
     */
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = "@trendyminds/square/assetbundles/squarefieldfield/dist";

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        $this->css = [
            'css/SquareField.css',
        ];

        $this->js = [
            'js/SquareField.js',
        ];

        parent::init();
    }
}
