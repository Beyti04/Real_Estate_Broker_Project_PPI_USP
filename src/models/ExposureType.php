<?php

namespace App\Models;

enum ExposureType: string{
    case NORTH = 'Север';
    case SOUTH = 'Юг';
    case EAST = 'Изток';
    case WEST = 'Запад';

    case NORTHEAST = 'Северо-Изток';
    case NORTHWEST = 'Северо-Запад';

    case SOUTHEAST = 'Юго-Изток';
    case SOUTHWEST = 'Юго-Запад';

    public static function getOptions(): array{
        $options=[];
        foreach(self::cases() as $case){
            $options[] = $case->value;
        }
        return $options;
    }
}