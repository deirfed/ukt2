<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KonfigurasiGudang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'konfigurasi_gudang';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function pulau()
    {
        return $this->belongsTo(Pulau::class);
    }

    public function seksi()
    {
        return $this->belongsTo(Seksi::class);
    }
}
