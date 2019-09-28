<?php

namespace Rich\Api;


interface Terminal
{
    public function setPricing(string $code, float $price, int $discountQty = null, float $discountPrice = null);

    public function scan(string $code, int $cartId);

    public function total(int $cartId);
}
