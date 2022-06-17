<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;

    protected $table ="sections";
    protected $fillable=['id','section_name','description','created_by'];


    public function products(){
        return $this->hasMany('App\Models\Products' , 'section_id' );
    }

}
