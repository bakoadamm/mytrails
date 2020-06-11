<?php
namespace App\Filter\Tracks;

use App\Filter\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class TrackFilter extends AbstractFilter
{
    protected $filters = [
        'tajegyseg' => RegionFilter::class
    ];
}
