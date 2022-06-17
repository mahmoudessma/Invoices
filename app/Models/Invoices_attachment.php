<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices_attachment extends Model
{
    use HasFactory;
    protected $table = 'invoices_attachment';
    protected $fillable = [
        'id',
       'invoices_number',
       'file_name',
       'created_by',
       'invoices_id'
   ];
}
