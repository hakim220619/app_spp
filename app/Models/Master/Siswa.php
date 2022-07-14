<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'student';

    protected $fillable = [
        'nis',
        'name',
        'email',
        'gender',
        'phone',
        'date_of_birth',
        'status',
        'class_id',
        'unit_id',
        'description',
        'year'
    ];
}
