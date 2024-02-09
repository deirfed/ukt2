<?php

namespace App\Models;

use App\Models\Walikota;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsi';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function walikota()
    {
        return $this->hasMany(Walikota::class);
    }

}
