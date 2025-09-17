<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cuti extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cuti';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function getFormattedTanggalAwalAttribute()
    {
        return Carbon::parse($this->tanggal_awal)->format('d-m-Y');
    }

    public function getFormattedTanggalAkhirAttribute()
    {
        return Carbon::parse($this->tanggal_akhir)->format('d-m-Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenis_cuti()
    {
        return $this->belongsTo(JenisCuti::class);
    }

    public function known_by()
    {
        return $this->belongsTo(User::class);
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class);
    }
}
