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
    ) {}
    
    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            
            if ($item->name === 'Sulfuras, Hand of Ragnaros') {
                continue;
            }
            
            $expired = $item->sellIn <= 0;
            
            if ($item->name === 'Aged Brie') {
                $item->quality = min(self::MAX_QUALITY, $item->quality + ($expired ? 2 : 1));
                $item->sellIn = $item->sellIn - 1;
                continue;
            }
            
            if ($item->name === 'Backstage passes to a TAFKAL80ETC concert'){
                $item->quality = $this->backStagePassQualitty($item);
                $item->sellIn = $item->sellIn - 1;
                continue;
            }
            
            $item->quality = max(0, min(self::MAX_QUALITY, $item->quality - ($expired ? 2 : 1)));
            $item->sellIn--;
            
        }
    }
    
    private function backStagePassQualitty(Item $item)
    {
        return match (true) {
            $item->sellIn <= 0 => 0,
            $item->sellIn <= 5 => min(self::MAX_QUALITY, $item->quality + 3),
            $item->sellIn <= 10 => min(self::MAX_QUALITY, $item->quality + 2),
            default => min(self::MAX_QUALITY, $item->quality + 1),
        };
    }
}
