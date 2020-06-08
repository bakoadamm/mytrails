<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $table = 'tracks';

    public function user() {
        return $this->belongsTo('App\Model\User');
    }
}
