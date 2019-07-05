<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class goods extends Model
{
    public $table = 'shop_goods';
    public  $timestamps = false;
    protected $primaryKey='goods_id';
}
