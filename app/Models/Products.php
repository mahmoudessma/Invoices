<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable= ['id' , 'product_name' , 'description' ,'section_id' ];



    public function sections()
    {
        return $this->belongsTo('App\Models\Sections','section_id' , 'id');
    }
}
