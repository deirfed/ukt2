<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FormasiTim extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'formasi_tim';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function struktur()
    {
        return $this->belongsTo(Struktur::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function koordinator()
    {
        return $this->belongsTo(User::class);
    }

    public function anggota()
    {
        return $this->belongsTo(User::class);
    }
}