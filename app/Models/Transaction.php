<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [''];

    /** 
     * add the date type to perform carbon operation on this date
    */
    protected $dates = ['transaction_date']; 


    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
