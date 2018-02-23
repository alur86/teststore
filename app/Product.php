<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   
  
protected $fillable = [
      'name', 'price' 
  ];



 public $timestamps = true;	
    
 protected $table = 'products';



 public function order()
    {
        return $this->hasMany('App\Order');
    }






}
