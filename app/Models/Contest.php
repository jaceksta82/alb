<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contest extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'receipt_number',
        'purchase_date',
        'receipt_image',
        'terms_accepted',
        'marketing_accepted',
    ];
}
