<?php

namespace Rich;


class PriceScanner
{
    private $timestamp;

    private $database;

    private $cart;

    public function __construct(int $timestamp)
    {
        $this->timestamp = $timestamp;
        $this->database = new \Filebase\Database([
            'dir' => __DIR__ . '/database'
        ]);
        $this->cart = $this->database->get($this->timestamp);
    }

    public function scan(string $code)
    {
        $this->cart->items[] = $code;
        $this->cart->save();
    }

    public function total()
    {
        $total = 0;
        foreach ($this->cart->items as $item) {
            $total += $this->database->get($item)->price;
        }

        echo $total . PHP_EOL;
    }
}