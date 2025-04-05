<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [ 'price', 'user_id'];
    public $translatedAttributes = ['name', 'description'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
