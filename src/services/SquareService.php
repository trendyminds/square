<?php
/**
 * Square plugin for Craft CMS 3.x
 *
 * Integrate the Square e-commerce platform into Craft
 *
 * @link      https://trendyminds.com
 * @copyright Copyright (c) 2018 TrendyMinds
 */

namespace trendyminds\square\services;

use trendyminds\square\Square;

use SquareConnect\Configuration;
use SquareConnect\ApiClient;
use SquareConnect\Api\CheckoutApi;
use SquareConnect\Model\CreateOrderRequestLineItem;
use SquareConnect\Model\CreateOrderRequest;
use SquareConnect\Model\CreateCheckoutRequest;

use Craft;
use craft\base\Component;

/**
 * SquareService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    TrendyMinds
 * @package   Square
 * @since     1.0.0
 */
class SquareService extends Component
{
    private $accessToken;
    private $locationId;
    private $apiConfig;
    private $apiClient;
    private $checkoutClient;

    public function __construct()
    {
        // Credentials
        $this->accessToken = Square::$plugin->settings->accessToken;
        $this->locationId = Square::$plugin->settings->locationID;

        // Authenticate to Square
        $this->apiConfig = Configuration::getDefaultConfiguration()->setAccessToken($this->accessToken);
        $this->apiClient = new ApiClient($this->apiConfig);
        $this->checkoutClient = new CheckoutApi($this->apiClient);
    }

    public function createOrderWithItems($items)
    {
        // Create an Order object using line items from above
        $order = new CreateOrderRequest();

        $order->setIdempotencyKey(uniqid()); // uniqid() generates a random string.

        // sets the lineItems array in the order object
        $order->setLineItems($items);

        $checkout = new CreateCheckoutRequest();
        $checkout->setIdempotencyKey(uniqid()); //uniqid() generates a random string.
        $checkout->setOrder($order); //this is the order we created in the previous step

        $output = (object) [];

        try {
            $result = $this->checkoutClient->createCheckout($this->locationId, $checkout);
            $checkoutId = $result->getCheckout()->getId();
            $output = (object) [
                "data" => $result->getCheckout()->getCheckoutPageUrl(),
                "status" => 200
            ];
        } catch (Exception $e) {
            $output = (object) [
                "data" => 'Exception when calling CheckoutApi->createCheckout: ' . $e->getMessage(),
                "status" => 500
            ];
        }

        return $output;
    }

    public function createCheckout($cartItems = [])
    {
        // Create an order using the items in the cart
        $lineItems = [];

        foreach ($cartItems as $cartItem) {
            $item = new CreateOrderRequestLineItem;
            $item->setCatalogObjectId($cartItem->id);
            $item->setQuantity((string) $cartItem->qty);
            array_push($lineItems, $item);
        }

        return $this->createOrderWithItems($lineItems);
    }
}
