<?php

namespace App\Models;

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