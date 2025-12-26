<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Eunms\User\UserStatus;
use App\Eunms\User\UserType;
use App\Models\Cart\Cart;
use App\Models\UsersType\Customer;
use App\Models\UsersType\Author;
use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles ,HasMedia ;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'password', 
        'type', 
        'status',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'type' => UserType::class,
            'status' => UserStatus::class,
        ];
    }

    public function scopeSearchByName($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $driver = $q->getConnection()->getDriverName();
            
            $fullNameSql = $driver === 'sqlite' 
                ? "first_name || ' ' || last_name" 
                : "CONCAT(first_name, ' ', last_name)";

            $q->whereRaw("$fullNameSql LIKE ?", ["%$search%"])
            ->orWhere('username', 'LIKE', "%$search%");
        });
    }

    public function customer() {
        return $this->hasOne(Customer::class, 'user_id')->withDefault(); 
    }

    public function author() { 
        return $this->hasOne(Author::class, 'user_id')->withDefault(); 
    }
    public function cart(){ 
        return $this->hasOne(Cart::class); 
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
