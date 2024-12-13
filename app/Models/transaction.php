<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'medicine_id',
        'medicinedevice_id',
        'status',
        'jumlah',   
        'total_harga',
        'tanggal_transaksi',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->transaksi_id = 'ID' . strtoupper(substr(md5(mt_rand()), 0, 9));
        });
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }

    public function medicinedevice()
    {
        return $this->belongsTo(MedicineDevice::class, 'medicinedevice_id');
    }
}
