<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $appends = ['image_url']; // untuk menambahkan atribut image_url ke dalam model dan di tampilan di postmant

    public function getImageUrlAttribute()
    {
        if($this->image == "") { // this image dpat dari database kolom image
            return "";
        }

        return asset('/uploads/products/small/' . $this->image);
    }
}
