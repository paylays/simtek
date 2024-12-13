<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk',
        'nama_obat',
        'kategori_id',
        'satuan_id',
        'stok',
        'harga',
        'keterangan',
        'suplier_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($medicine) {
            $medicine->kode_produk = 'OBAT' . strtoupper(substr(md5(mt_rand()), 0, 7));
        });
    }

    public function kategori()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Unit::class, 'satuan_id');
    }

    public function suplier()
    {
        return $this->belongsTo(Supplier::class, 'suplier_id');
    }

    public function transactionmedicine()
    {
        return $this->hasMany(transaction::class, 'medicine_id');
    }
    public function transactionmedicinedevice()
    {
        return $this->hasMany(transaction::class, 'medicinedevice_id');
    }
}
