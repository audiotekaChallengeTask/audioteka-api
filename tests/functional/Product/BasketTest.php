<?php
declare(strict_types=1);

namespace App\Tests\Functional\Product;

use App\Entity\Product;
use App\Tests\Functional\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class BasketTest extends ApiTestCase
{
    private function getAddProductToBasketUrl(Product $product)
    {
        return '/api/product/' . $product->getId() . '/add-to-basket';
    }

    private function getRemoveProductFromBasketUrl(Product $product)
    {
        return '/api/product/' . $product->getId() . '/remove-from-basket';
    }

    public function test_it_should_create_basket_when_there_is_none()
    {
        $this->client->request('POST', '/api/basket');
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'basket/create', Response::HTTP_CREATED);
    }

    public function test_it_should_not_allow_creating_more_than_one_basket()
    {
        $this->loadFixturesFromFile('resources/baskets.yml');
        $this->client->request('POST', '/api/basket');
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'basket/no_multiple_baskets', Response::HTTP_BAD_REQUEST);
    }

    public function test_it_should_return_empty_basket()
    {
        $this->loadFixturesFromFile('resources/baskets.yml');
        $this->client->request('GET', '/api/basket');
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'basket/empty_basket', Response::HTTP_OK);
    }

    public function test_it_should_allow_to_add_one_product()
    {
        $data    = $this->loadFixturesFromFiles(
            [
                'resources/baskets.yml',
                'resources/products.yml'
            ]
        );
        $product = $data['product1'];

        $this->client->request('POST', $this->getAddProductToBasketUrl($product));

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'basket/single_product_added', Response::HTTP_ACCEPTED);
    }

    public function test_it_should_not_allow_to_remove_product_from_empty_basket()
    {
        $data    = $this->loadFixturesFromFiles(
            [
                'resources/baskets.yml',
                'resources/products.yml'
            ]
        );
        $product = $data['product1'];

        $this->client->request('DELETE', $this->getRemoveProductFromBasketUrl($product));

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'basket/product_not_in_basket', Response::HTTP_BAD_REQUEST);
    }

    public function test_it_should_allow_to_remove_product_from_basket()
    {
        $data    = $this->loadFixturesFromFile('resources/basket_with_product.yml');
        $product = $data['product1'];

        $this->client->request('DELETE', $this->getRemoveProductFromBasketUrl($product));

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'basket/basket_with_removed_product', Response::HTTP_ACCEPTED);
    }

    public function test_it_should_allow_to_add_same_product_more_than_once()
    {
        $data    = $this->loadFixturesFromFile('resources/basket_with_product.yml');
        $product = $data['product1'];

        $this->client->request('POST', $this->getAddProductToBasketUrl($product));

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'basket/basket_already_contains_element', Response::HTTP_BAD_REQUEST);
    }
}
