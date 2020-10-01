<?php
declare(strict_types=1);

namespace App\Tests\Functional\Product;

use App\Entity\Product;
use App\Tests\Functional\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductTest extends ApiTestCase
{
    private function getProductUrl(Product $product)
    {
        return '/api/product/' . $product->getId();
    }

    public function test_it_should_return_existing_products()
    {
        $this->loadFixturesFromFile('resources/products.yml');
        $this->client->request('GET', '/api/product');
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'product/paginated_index', Response::HTTP_OK);
    }

    public function test_it_should_create_product()
    {
        $this->loadFixturesFromFile('resources/products.yml');
        $data =
<<<EOT
        {
            "name": "Product 1",
            "price": 199.99
        }
EOT;

        $this->client->request('POST', '/api/product', [], [], self::$defaultHeaders, $data);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'product/create', Response::HTTP_CREATED);
    }

    public function test_it_should_allow_to_partially_update_product_with_name()
    {
        $products = $this->loadFixturesFromFile('resources/products.yml');
        $product = $products['product1'];
        $data =
<<<EOT
        {
            "name": "New Name"
        }
EOT;

        $this->client->request('PATCH', $this->getProductUrl($product), [], [], self::$defaultHeaders, $data);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'product/patch_name', Response::HTTP_ACCEPTED);
    }

    public function test_it_should_allow_to_partially_update_product_with_price()
    {
        $products = $this->loadFixturesFromFile('resources/products.yml');
        $product = $products['product1'];
        $data =
<<<EOT
        {
            "price": 799.99
        }
EOT;

        $this->client->request('PATCH', $this->getProductUrl($product), [], [], self::$defaultHeaders, $data);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'product/patch_price', Response::HTTP_ACCEPTED);
    }

    public function test_it_should_return_error_on_too_low_price_when_editing_existing_product()
    {
        $products = $this->loadFixturesFromFile('resources/products.yml');
        $product = $products['product1'];
        $data =
<<<EOT
        {
            "price": 0
        }
EOT;

        $this->client->request('PATCH', $this->getProductUrl($product), [], [], self::$defaultHeaders, $data);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'product/invalid_invalid_price', Response::HTTP_BAD_REQUEST);
    }

    public function test_it_should_return_error_on_missing_name_when_creating_new_product()
    {
        $data =
<<<EOT
        {
            "price": 199.99
        }
EOT;

        $this->client->request('POST', '/api/product', [], [], self::$defaultHeaders, $data);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'product/invalid_missing_name', Response::HTTP_BAD_REQUEST);
    }

    public function test_it_should_return_error_on_missing_price_when_creating_new_product()
    {
        $data =
<<<EOT
        {
            "name": "New product name"
        }
EOT;

        $this->client->request('POST', '/api/product', [], [], self::$defaultHeaders, $data);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'product/invalid_missing_price', Response::HTTP_BAD_REQUEST);
    }

    public function test_it_should_return_error_on_too_low_price_when_creating_new_product()
    {
        $data =
<<<EOT
        {
            "name": "New product name",
            "price": 0
        }
EOT;

        $this->client->request('POST', '/api/product', [], [], self::$defaultHeaders, $data);
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'product/invalid_invalid_price', Response::HTTP_BAD_REQUEST);
    }
}
