<?php

namespace App\Models;
enum ListingType: string {
    case SALE = 'sale';
    case RENT = 'rent';

    public static function getOptions(): array{
        $options=[];
        foreach(self::cases() as $case){
            $options[] = $case->value;
        }
        return $options;
    }
}