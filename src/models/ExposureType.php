<?php

namespace App\Models;

enum ExposureType: string{
    case NORTH = 'North';
    case SOUTH = 'South';
    case EAST = 'East';
    case WEST = 'West';

    case NORTHEAST = 'North-East';
    case NORTHWEST = 'North-West';

    case SOUTHEAST = 'South-East';
    case SOUTHWEST = 'South-West';

    public static function getOptions(): array{
        $options=[];
        foreach(self::cases() as $case){
            $options[] = $case->value;
        }
        return $options;
    }
}