<?php

namespace App\Model;

use App\Filter\Tracks\TrackFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Model\Region;

class Track extends Model
{
    protected $table = 'tracks';

    public function scopeFilter(Builder $builder, $request) {
        return (new TrackFilter($request))->filter($builder);
    }

    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function region() {
        return $this->belongsToMany(Region::class, 'track_regions');
    }
}
