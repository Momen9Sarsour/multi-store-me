<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;



class Store extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name','description','image','status','slug'
    ];
    protected $hidden=[
        'created_at','updated_at','email','password'
      ];
    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }


    public function users()
    {
        return $this->hasMany(User::class, 'store_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function orders(){
        return $this->belongsToMany(Order::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function getImageUrlAttribute(){
        if(!$this->image){
            return 'https://www.ehabra.com/storage/images/documents/_res/wrh/def_product.png';
        }
        if(str::startsWith($this->image,['http://','https://'])){
            return $this->image;
        }
  
        return asset('storage/' . $this->image);
     }
}
