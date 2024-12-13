<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_suplier',
        'nomor_hp',
        'email',
        'alamat'
    ];

    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'suplier_id');
    }
}
