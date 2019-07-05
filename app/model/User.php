<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table='shop_user';
    public $timestamps=false;
    protected $primaryKey='user_id';
}
