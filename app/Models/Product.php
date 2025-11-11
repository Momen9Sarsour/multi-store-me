<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Product extends Model
{

    use HasFactory,softDeletes;
    protected $fillable=[
        'name','slug','description','image','category_id','store_id',
        'price','compare_price','status','storgeQuantity','featured'
    ];
    protected $hidden=[
      'created_at','updated_at','deleted_at','image'
    ];
    protected $appends=[
      'image_url'
    ];
    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());
        static::creating(function(Product $product){
         $product->Slug =Str::slug($product->name);
        });
    }

    public function scopeActive(Builder $builder){
        $builder->where('status','=','active');
    }
    public function scopeQuantity(Builder $builder){
        $builder->where('storgeQuantity', '>', 0);
    }
    public function getDiscountedProducts()
    {
        return $this->whereColumn('price', '<', 'compare_price')->get();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
        // return $this->belongsTo(Category::class)->withDefault();
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.ehabra.com/storage/images/documents/_res/wrh/def_product.png';
        }
        if (str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }
    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return number_format(100 - (100 * $this->price / $this->compare_price), 1);
    }

    public function scopeDiscounted($query)
    {
        return $query->whereRaw('(price / compare_price) >= 0.7');
    }

    public function scopeFiftyPercentOffer($query)
    {
        return $query->whereRaw('(price / compare_price) = 0.5');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }
    public function scopeLargeDiscounted($query)
    {
        return $query->whereRaw('(price / compare_price) < 0.5');
    }
    public function tags(){
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id',
            'id',
            'id'
        );
     }
     public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'], function ($query, $status) {
            return $query->where('status', $status);
        });

        $builder->when($options['store_id'], function($builder, $value) {
            $builder->where('store_id', $value);
        });
        $builder->when($options['category_id'], function($builder, $value) {
            $builder->where('category_id', $value);
        });
        $builder->when($options['tag_id'], function($builder, $value) {

            $builder->whereExists(function($query) use ($value) {
                $query->select(1)
                    ->from('product_tag')
                    ->whereRaw('product_id = products.id')
                    ->where('tag_id', $value);
            });
    });
   
     }
}

