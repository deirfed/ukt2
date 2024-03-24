<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransaksiBarangPulau extends Model
{
    use HasFactory;

    protected $table = 'transaksi_barang_pulau';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function barang_pulau()
    {
        return $this->belongsTo(BarangPulau::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
