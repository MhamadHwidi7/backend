<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
      'name',
      //'email',
      'phone_number',
      'gender',
      //'password',
       // 'user_id',
        'branch_id',
      'mother_name',
       'birth_date',
       'birth_place',
       'mobile',
        'address',
       // 'national_number',
       // 'vacations',
        'salary',
        'rank',
      //  'rewards',
        'employment_date',
        'resignation_date',
        'manager_name',
          ]; 
          public function user(){
            return $this->belongsTo(user::class, 'user_id');
         }
         public function trip(){
             return $this->hasMany(trip::class, 'truck_id');
         }
}
