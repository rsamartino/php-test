<?php

namespace Rich\Api;


interface Terminal
{
    /**
     * specify system prices
     *
     * @param string $code
     * @param float $price
     * @param int|null $discountQty
     * @param float|null $discountPrice
     * @return mixed
     */
    public function setPricing(string $code, float $price, int $discountQty = null, float $discountPrice = null);

    /**
     * scan items and save to cart
     *
     * @param string $code
     * @param int $cartId
     * @return mixed
     */
    public function scan(string $code, int $cartId);

    /**
     * calculate cart total
     *
     * @param int $cartId
     * @return mixed
     */
    public function total(int $cartId);
}
