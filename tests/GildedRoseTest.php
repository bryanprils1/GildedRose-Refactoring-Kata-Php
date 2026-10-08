<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {
        $items = [new Item('foo', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->name);
    }

    public function testConjuredDegradesTwiceAsFast(): void
    {
        $items = [new Item('Conjured Mana Cake', 3, 6)];
        (new GildedRose($items))->updateQuality();
        $this->assertSame(4, $items[0]->quality);
    }
}
