<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    private const MAX_QUALITY = 50;

    /**
     * @param  Item[]  $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if ($item->name === 'Sulfuras, Hand of Ragnaros') {
                continue;
            }

            $expired = $item->sellIn <= 0;

            if ($item->name === 'Aged Brie') {
                $item->quality = $this->increase($item->quality, $expired ? 2 : 1);
                $item->sellIn = $item->sellIn - 1;
                continue;
            }

            if ($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
                $item->quality = $this->backStagePassQuality($item);
                $item->sellIn--;
                continue;
            }

            if (str_starts_with($item->name, 'Conjured')) {
                $item->quality = $this->decrease($item->quality, $expired ? 4 : 2);
                $item->sellIn--;
                continue;
            }

            $item->quality = $this->decrease($item->quality, $expired ? 2 : 1);
            $item->sellIn--;
        }
    }

    private function backStagePassQuality(Item $item): int
    {
        return match (true) {
            $item->sellIn <= 0 => 0,
            $item->sellIn <= 5 => $this->increase($item->quality, 3),
            $item->sellIn <= 10 => $this->increase($item->quality, 2),
            default => $this->increase($item->quality, 1),
        };
    }

    private function increase(int $quality, int $by): int
    {
        return max($quality, min(self::MAX_QUALITY, $quality + $by));
    }

    private function decrease(int $quality, int $by): int
    {
        return min($quality, max(0, $quality - $by));
    }
}
