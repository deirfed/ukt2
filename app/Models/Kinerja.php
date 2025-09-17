<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Kinerja extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kinerja';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();

            $timestamp = now()->format('YmdHis');
            $randomNumber = mt_rand(1000, 9999);

            $model->ticket_number = $timestamp . $randomNumber;
        });
    }

    public function getFormattedTanggalAttribute()
    {
        return Carbon::parse($this->tanggal)->format('d-m-Y');
    }

    public function getHariAttribute()
    {
        return $this->tanggal
            ? Carbon::parse($this->tanggal)->locale('id')->dayName
            : null;
    }

    public function formasi_tim()
    {
        return $this->belongsTo(FormasiTim::class);
    }

    public function unitkerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function seksi()
    {
        return $this->belongsTo(Seksi::class);
    }

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }

    public function pulau()
    {
        return $this->belongsTo(Pulau::class);
    }

    public function koordinator()
    {
        return $this->belongsTo(User::class);
    }

    public function anggota()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
