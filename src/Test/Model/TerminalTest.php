<?php

namespace Rich\Test\Model;

use Rich\Model\Terminal;

class TerminalTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var Terminal
     */
    private $terminal;

    /**
     * @var \Filebase\Database
     */
    private $database;

    protected function setUp(): void
    {
        $this->terminal = new Terminal();
        $this->database = new \Filebase\Database([
            'dir' => __DIR__ . '/../../database'
        ]);
    }

    public function testTotal()
    {

    }

    public function testScan()
    {

    }

    public function testSetPricing()
    {
        $this->terminal->setPricing('A', 2, 4, 7);
        $this->terminal->setPricing('B', 12);
        $this->terminal->setPricing('C', 1.25, 6, 6);
        $this->terminal->setPricing('D', .15);

        $a = $this->database->get('A');
        $b = $this->database->get('B');
        $c = $this->database->get('C');
        $d = $this->database->get('D');

        $this->assertEquals(2, $a->price);
        $this->assertEquals(4, $a->discountQty);
        $this->assertEquals(7, $a->discountPrice);

        $this->assertEquals(12, $b->price);
        $this->assertEquals(null, $b->discountQty);
        $this->assertEquals(null, $b->discountPrice);

        $this->assertEquals(1.25, $c->price);
        $this->assertEquals(6, $c->discountQty);
        $this->assertEquals(6, $c->discountPrice);

        $this->assertEquals(.15, $d->price);
        $this->assertEquals(null, $d->discountQty);
        $this->assertEquals(null, $d->discountPrice);

    }

    public function test__construct()
    {

    }
}
