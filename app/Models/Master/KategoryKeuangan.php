<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoryKeuangan extends Model
{
    use HasFactory;

    protected $table = 'category_payment';

    protected $fillable = [
        'name',
        'amount',
        'type'
    ];
}
