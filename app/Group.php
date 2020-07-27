<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $casts = [
        'id'   => 'integer',
        'name' => 'string',
    ];
}
