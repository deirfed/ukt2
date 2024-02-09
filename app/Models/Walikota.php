<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Walikota extends Model
{
    use HasFactory;

    protected $table = 'walikota';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
}
