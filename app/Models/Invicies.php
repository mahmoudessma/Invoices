<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invicies extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'invices';
     protected $fillable = [
         'id',
        'invoice_number',
        'invoice_Date',
        'Due_date',
        'product',
        'section_id',
        'Amount_collection',
        'Amount_Commission',
        'Discount',
        'Value_VAT',
        'Rate_VAT',
        'Total',
        'Status',
        'Value_Status',
        'note',
        'Payment_Date',
    ];

    protected $dates = ['deleted_at'];

 public function sections()
   {
   return $this->belongsTo('App\Models\sections','section_id');
   }
   public function Invoices_details()
   {
   return $this->hasMany('App\Models\Invoices_details','id_invoices', 'id');
   }
   

    
}
