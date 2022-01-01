<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class , 'model_has_roles' , 'model_id' , 'role_id');
    }

    public function isSuperAdmin()
    {
        return $this->roles->contains('name', 'super_admin');
    }

    public function isAdmin()
    {
        return $this->roles->contains('name', 'admin');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class , 'model_has_permissions' , 'model_id' , 'permission_id');
    }

    public function cans($permission){
        return $this->permissions->contains('name', $permission);
    }

    public function department(){
        return $this->hasOne(Department::class,'id','department_id');
    }

    public function stocks(){
        return $this->hasMany(Stock::class,'id','stock_id');
    }

    public function sales(){
        return $this->hasMany(Sale::class,'id','sale_id');
    }

    public function products(){
        return $this->hasMany(Product::class,'id','product_id');
    }
}
