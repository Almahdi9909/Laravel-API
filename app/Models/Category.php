<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // protected $table = 'categories' ;

    protected $fillable = ['name'];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
    //this booted global scope will be added to all elqount queries u made
    protected static function booted()
    {
        if(auth()->check())
        {
            static::addGlobalScope('by_user', function (Builder $builder) {
                $builder->where('user_id',auth()->user()->id);
            });  
        }
    }
}
