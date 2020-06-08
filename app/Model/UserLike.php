<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserLike extends Model {
    protected $table = 'user_likes';

    public $timestamps = false;

    public function user() {
        return $this->hasMany('App\Model\User');
    }

    public function track() {
        return $this->hasMany('App\Model\Track');
    }
}
