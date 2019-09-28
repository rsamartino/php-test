<?php

namespace Rich;


class PriceScanner
{
    private $timestamp;

    private $database;

    private $cart;

    public function __construct(float $timestamp)
    {
        $this->timestamp = $timestamp;
        $this->database = new \Filebase\Database([
            'dir' => __DIR__ . '/database'
        ]);
        $this->cart = $this->database->get($this->timestamp);
        $this->cart->save();
    }

    public function scan(string $code)
    {
        $this->cart->items[] = $code;
        $this->cart->save();
    }

    public function total()
    {
        $total = 0;

//        print_r(array_count_values($this->cart->items));

        foreach (array_count_values($this->cart->items) as $code => $count) {
            $priceData = $this->database->get($code);
            if ($priceData->discountQty && ($count <=> $priceData->discountQty) >= 0) {
                echo "$code is greater" . PHP_EOL . ($count - $priceData->discountQty) . PHP_EOL . PHP_EOL;
                $total += $priceData->discountPrice + (($count - $priceData->discountQty) * $priceData->price);
                echo 'total: ' . $total . PHP_EOL;
            } else {
                echo "$code is not greater" . PHP_EOL;
                $total += $this->database->get($code)->price * $count;
            }
        }

//        foreach ($this->cart->items as $item) {
//        }



        echo $total . PHP_EOL;
    }
}