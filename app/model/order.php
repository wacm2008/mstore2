<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table='shop_order';
    public $timestamps=false;
    protected $primaryKey='order_id';
}
