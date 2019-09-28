<?php

require __DIR__ . '/vendor/autoload.php';

$priceSetter = new \Rich\PriceSetter();

$priceSetter->setPricing('A', 2, 4, 7);
$priceSetter->setPricing('B', 12);
$priceSetter->setPricing('C', 1.25, 6, 6);
$priceSetter->setPricing('D', .15);


$priceScanner = new \Rich\PriceScanner(microtime());

$priceScanner->scan('A');
$priceScanner->scan('B');
$priceScanner->scan('C');
$priceScanner->scan('D');
$priceScanner->scan('A');
$priceScanner->scan('B');
$priceScanner->scan('A');
$priceScanner->scan('A');

$result = $priceScanner->total();

echo $result . PHP_EOL;

$priceScanner = new \Rich\PriceScanner(microtime());

$priceScanner->scan('C');
$priceScanner->scan('C');
$priceScanner->scan('C');
$priceScanner->scan('C');
$priceScanner->scan('C');
$priceScanner->scan('C');
$priceScanner->scan('C');

$result = $priceScanner->total();

echo $result . PHP_EOL;


$priceScanner = new \Rich\PriceScanner(microtime());

$priceScanner->scan('A');
$priceScanner->scan('B');
$priceScanner->scan('C');
$priceScanner->scan('D');

$result = $priceScanner->total();

echo $result . PHP_EOL;