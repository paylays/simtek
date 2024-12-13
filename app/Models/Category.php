<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori', 
        'jumlah'
    ];

    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'kategori_id');
    }

    // public function medicineDevices()
    // {
    //     return $this->hasMany(MedicineDevice::class, 'kategori_id');
    // }

    public function totalCount()
    {
        return $this->medicines->count() + $this->medicineDevices()->count();
    }
}
