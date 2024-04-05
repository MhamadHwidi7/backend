<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Warehouse_Manager extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'warehouse_managers';
    protected $guared = 'warehouse_manager';
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'gender',
        'password',
        'warehouse_id',
        //'user_id',
        
         ];
         public function user(){
            return $this->belongsTo(user::class, 'user_id');
         }

         public function warehouse(){
            return $this->belongsTo(Warehouse::class , 'warehouse_id');
         }

         public function getJWTIdentifier()
         {
             return $this->getKey();
         }
     
         public function getJWTCustomClaims()
         {
             return [];
         }
}
