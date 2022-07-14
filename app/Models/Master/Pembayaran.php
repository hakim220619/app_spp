<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
        'id',
        'student_id',
        'description',
        'category_payment_id',
        'amount',
        'adjusment_amount',
        'payment_method',
    ];
}
