<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Absensi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'absensi';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function getFormattedTanggalAttribute()
    {
        return Carbon::parse($this->tanggal)->format('d-m-Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenis_absensi()
    {
        return $this->belongsTo(JenisAbsensi::class);
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
