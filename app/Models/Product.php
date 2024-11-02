<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'category_id',
        'store_id',
        'price',
        'compare_price',
        'status'
    ];
    protected static function booted()
    {
        // static::addGlobalScope('store', function (Builder $builder) {
        //     $user = Auth::user();
        //     if ($user->store_id) {
        //         $builder->where('store_id', '=', $user->store_id);
        //     }
        // });
        static::addGlobalScope('store', new StoreScope());
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id', // FK in pivot table for the current model
            'tag_id',
            'id',
            'id'
        );
    }

    public function scopeActive(Builder $builder)
    {
        $builder->whereStatus('active');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return "https://upload.wikimedia.org/wikipedia/commons/1/14/Product_sample_icon_picture.png";
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset("storage/" . $this->image);
    }

    // Accessors
    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return number_format(100 - (100 * $this->price / $this->compare_price), 2);
    }


}
