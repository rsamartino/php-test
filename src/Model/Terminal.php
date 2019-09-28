<?php

namespace Rich\Model;


class Terminal implements \Rich\Api\Terminal
{
    private $database;

    public function __construct(\Filebase\Database $database)
    {
        $this->database = $database;
    }

    public function setPricing(string $code, float $price, int $discountQty = null, float $discountPrice = null)
    {
        $item = $this->database->get($code);
        $item->price = $price;
        $item->discountQty = $discountQty;
        $item->discountPrice = $discountPrice;
        $item->save();
    }

    public function scan(string $code, int $cartId)
    {
        $cart = $this->database->get($cartId);
        $cart->items[] = $code;
        $cart->save();
    }

    public function total(int $cartId)
    {
        $total = 0;
        $cart = $this->database->get($cartId);

        foreach (array_count_values($cart->items) as $code => $count) {
            $priceData = $this->database->get($code);
            if ($priceData->discountQty && ($count - $priceData->discountQty) >= 0) {
                $numberOfDiscountQtys = intdiv($count, $priceData->discountQty); //return integer quotient of the division
                echo $numberOfDiscountQtys . PHP_EOL;
                $numberOfNonDiscountItems = $count % $priceData->discountQty; //find division remainder
                echo $numberOfNonDiscountItems . PHP_EOL;

                $total += $numberOfDiscountQtys * $priceData->discountPrice + ($numberOfNonDiscountItems * $priceData->price);
            } else {
                $total += $this->database->get($code)->price * $count;
            }
        }

        return $total;
    }
}
