<?php

namespace App\Filter\Tracks;

class RegionFilter {
    public function filter($builder, $value) {
        $selectedRegions = explode(',', $value);
        return $builder->whereHas('region', function($query) use($selectedRegions) {
            $query->whereIn('slug', $selectedRegions);
        })->orderBy('created_at', 'desc');
    }
}
