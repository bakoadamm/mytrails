<?php
/**
 * Created by PhpStorm.
 * User: bakoa
 * Date: 2019. 07. 17.
 * Time: 11:43
 */

namespace App\Filter\Tracks;

class FreeWordFilter {
    public function filter($builder, $value) {
        return $builder->where('title', 'LIKE', '%'.$value.'%');
    }
}
