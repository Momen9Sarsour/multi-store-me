<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use HasFactory,softDeletes;
    protected $guarded = [];
  
    protected $attributes = [
        'email' => null,
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function user()
    {
     return $this->belongsTo(User::class);
    }
    public static function rules($id=0) {
 
        return[
           'name'=>[     
             'required','string','min:3','max:255',"unique:employees,name,$id",
           ],
           'email' => [
            'required', 'email', "unique:employees,email,$id",
          ],
           'image'=>[
             'image','max:1048576','dimensions:min_width=100,min_height=100'
           ],
           
         ];
     }
}
