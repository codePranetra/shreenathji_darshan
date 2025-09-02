<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasPermission extends Model
{
    use HasFactory;

    protected $fillable = ['permission_id', 'role_id', 'user_id'];

    public function permission(){
        return $this->belongsTo(Permission::class);
    }

}
