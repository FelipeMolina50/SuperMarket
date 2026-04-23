<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'company_name',
        'avatar',
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
        ];
    }

    public function avatarHtml($size = '40px', $text = '1.25rem')
    {
        $avatarStr = $this->avatar ?? 'default';
        
        if (str_contains($avatarStr, 'avatars/')) {
            $url = asset('storage/' . $avatarStr);
            return '<img src="'.$url.'" class="avatar-img" style="width:'.$size.'; height:'.$size.'; border-radius:50%; object-fit:cover; border:2px solid white; box-shadow:0 1px 2px rgba(0,0,0,0.1); cursor:pointer;">';
        }

        $avatars = [
            'fox' => '<div class="avatar-img" style="width:'.$size.'; height:'.$size.'; border-radius:50%; background:#ffedd5; display:flex; align-items:center; justify-content:center; font-size:'.$text.'; border: 2px solid white; box-shadow: 0 1px 2px rgba(0,0,0,0.1); cursor:pointer;">🦊</div>',
            'cat' => '<div class="avatar-img" style="width:'.$size.'; height:'.$size.'; border-radius:50%; background:#dbeafe; display:flex; align-items:center; justify-content:center; font-size:'.$text.'; border: 2px solid white; box-shadow: 0 1px 2px rgba(0,0,0,0.1); cursor:pointer;">🐱</div>',
            'dog' => '<div class="avatar-img" style="width:'.$size.'; height:'.$size.'; border-radius:50%; background:#dcfce7; display:flex; align-items:center; justify-content:center; font-size:'.$text.'; border: 2px solid white; box-shadow: 0 1px 2px rgba(0,0,0,0.1); cursor:pointer;">🐶</div>',
            'panda' => '<div class="avatar-img" style="width:'.$size.'; height:'.$size.'; border-radius:50%; background:#fce7f3; display:flex; align-items:center; justify-content:center; font-size:'.$text.'; border: 2px solid white; box-shadow: 0 1px 2px rgba(0,0,0,0.1); cursor:pointer;">🐼</div>',
        ];

        if (array_key_exists($avatarStr, $avatars)) {
            return $avatars[$avatarStr];
        }
        
        $initial = strtoupper(substr($this->name ?? 'U', 0, 1));
        return '<div class="avatar-img" style="width:'.$size.'; height:'.$size.'; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; font-size:'.$text.'; color:#64748b; font-weight:bold; border: 2px solid white; box-shadow: 0 1px 2px rgba(0,0,0,0.1); cursor:pointer;">'.$initial.'</div>';
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
