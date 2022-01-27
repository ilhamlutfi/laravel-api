<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // select data yang perlu saja dari category
    public function toArray()
    {
         return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug
         ];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}
