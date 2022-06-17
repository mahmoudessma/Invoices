<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices_details extends Model
{
    use HasFactory;
    protected $table = 'invoices_details';
    protected $fillable = [
        'id',
        'id_invoices',
       'invoices_number',
       'product',
       'section',
       'status',
       'value_status',
       'note',
       'user',
       'Payment_Date'
   ];
   public function invicies()
   {
   return $this->belongsTo('App\Models\Invicies','id_invoices');
   }
}
