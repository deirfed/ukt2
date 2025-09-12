<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategori';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function seksi()
    {
        return $this->belongsTo(Seksi::class);
    }

    public function kinerja()
    {
        return $this->hasMany(Kinerja::class);
    }


    public function cekRelasi()
    {
        if ($this->kinerja()->exists()) {
            return false;
        }

        return true;
    }
}
