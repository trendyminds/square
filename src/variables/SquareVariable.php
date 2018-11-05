<?php
/**
 * Square plugin for Craft CMS 3.x
 *
 * @link      https://trendyminds.com
 * @copyright Copyright (c) 2018 TrendyMinds
 */

namespace trendyminds\square\variables;

use trendyminds\square\Square;

use Craft;

/**
 * Square Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.square }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    TrendyMinds
 * @package   Square
 * @since     1.0.0
 */
class SquareVariable
{
    public function products()
    {
        $result = Square::$plugin->squareService->getProducts();
        return $result->data;
    }

    public function details($productList = "")
    {
        return Square::$plugin->squareService->getProductDetails(json_decode($productList));
    }
}
