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
        $this->database = new \Filebase\Database([
            'dir' => __DIR__ . '/testDatabase'
        ]);
        $this->terminal = new Terminal($this->database);
        $this->setPricing();
    }

    protected function tearDown(): void
    {
        $this->database->truncate();
    }

    public function testScenario1()
    {
        $this->terminal->scan('A', 1);
        $this->terminal->scan('B', 1);
        $this->terminal->scan('C', 1);
        $this->terminal->scan('D', 1);
        $this->terminal->scan('A', 1);
        $this->terminal->scan('B', 1);
        $this->terminal->scan('A', 1);
        $this->terminal->scan('A', 1);

        $this->assertEquals(32.4, $this->terminal->total(1));
    }

    public function testScenario2()
    {
        $this->terminal->scan('C', 2);
        $this->terminal->scan('C', 2);
        $this->terminal->scan('C', 2);
        $this->terminal->scan('C', 2);
        $this->terminal->scan('C', 2);
        $this->terminal->scan('C', 2);
        $this->terminal->scan('C', 2);

        $this->assertEquals(7.25, $this->terminal->total(2));
    }

    public function testScenario3()
    {
        $this->terminal->scan('A', 3);
        $this->terminal->scan('B', 3);
        $this->terminal->scan('C', 3);
        $this->terminal->scan('D', 3);

        $this->assertEquals(15.4, $this->terminal->total(3));
    }

    private function setPricing()
    {
        $this->terminal->setPricing('A', 2, 4, 7);
        $this->terminal->setPricing('B', 12);
        $this->terminal->setPricing('C', 1.25, 6, 6);
        $this->terminal->setPricing('D', .15);
    }

}
