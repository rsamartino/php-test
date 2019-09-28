<?php

namespace Rich;


class PriceSetter
{
    public function setPricing(string $code, float $price, int $discountQty = null, float $discountPrice = null)
    {
        // setting the access and configration to your database
        $database = new \Filebase\Database([
            'dir' => __DIR__ . '/database'
        ]);

        $item = $database->get($code);
        $item->price = $price;
        $item->discountQty = $discountQty;
        $item->discountPrice = $discountPrice;
        $item->save();
    }
}