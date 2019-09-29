<?php

namespace Rich\Model;


class Terminal implements \Rich\Api\Terminal
{
    /**
     * @var \Filebase\Database
     */
    private $database;

    /**
     * Terminal constructor.
     * @param \Filebase\Database $database
     */
    public function __construct(\Filebase\Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param string $code
     * @param float $price
     * @param int|null $discountQty
     * @param float|null $discountPrice
     * @return mixed|void
     */
    public function setPricing(string $code, float $price, int $discountQty = null, float $discountPrice = null)
    {
        $item = $this->database->get($code); //create or update price by code
        $item->price = $price;
        $item->discountQty = $discountQty;
        $item->discountPrice = $discountPrice;
        $item->save();
    }

    /**
     * @param string $code
     * @param int $cartId
     * @return mixed|void
     */
    public function scan(string $code, int $cartId)
    {
        $cart = $this->database->get($cartId); //create or update shopping cart
        $cart->items[] = $code; //add array of items
        $cart->save();
    }

    /**
     * @param int $cartId
     * @return float|int|mixed
     */
    public function total(int $cartId)
    {
        $total = 0;
        $cart = $this->database->get($cartId);

        foreach (array_count_values($cart->items) as $code => $count) { //iterate through count of each item type
            $priceData = $this->database->get($code); //get product price data

            if ($priceData->discountQty && ($count - $priceData->discountQty) >= 0) { //check if count meets discount threshold
                $numberOfDiscountQtys = intdiv($count, $priceData->discountQty); //return integer quotient of the division
                $numberOfNonDiscountItems = $count % $priceData->discountQty; //find division remainder

                //calculate total based on above info
                $total += $numberOfDiscountQtys * $priceData->discountPrice + $numberOfNonDiscountItems * $priceData->price;
            } else {
                $total += $priceData->price * $count;
            }
        }

        return $total;
    }
}
