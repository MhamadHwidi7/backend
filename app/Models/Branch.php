<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
   'address',
   'desk',
    'phone',
    'opening_date',
    'closing_date',
    'created_by',
    'edited_by',
    'editing_date',

   
    ];
    public function branch_manager(){
        return $this->belongsTo(branch_manager::class, 'branchmanager_id');
    }
    public function employee(){
        return $this->hasMany(employee::class, 'branch_id');
    }
    public function trip(){
        return $this->hasMany(trip::class, 'branch_id');
    }
    public function trucks(){
        return $this->hasMany(Truck::class, 'branch_id');
    }   
}
