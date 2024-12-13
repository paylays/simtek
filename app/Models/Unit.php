<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_satuan',
        'jumlah'
    ];

    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'satuan_id');
    }

    public function medicineDevices()
    {
        return $this->hasMany(MedicineDevice::class, 'satuan_id');
    }

    public function totalCount()
    {
        return $this->medicines->count() + $this->medicineDevices()->count();
    }

}
