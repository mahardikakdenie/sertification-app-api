<?php

namespace App\Models;

use App\Http\Helpers\MethodsHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schema extends Model
{
    use HasFactory;


    public function users()
    {
        return $this->hasMany(User::class, 'schema_id');
    }

    public function scopeEntities($query, $entitites)
    {
        MethodsHelpers::entities($query, $entitites);
    }
}
