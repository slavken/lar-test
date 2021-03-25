<?php

namespace App\Models;

use App\Scopes\ModuleScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ModuleScope);
    }
}
