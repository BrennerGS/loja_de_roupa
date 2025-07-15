<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'is_admin',
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

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    
    public function hasPermission($slug)
    {
        // Se for admin, tem todas as permissões
        if ($this->is_admin) {
            return true;
        }
        
        return $this->permissions()->where('slug', $slug)->exists();
    }
    
    public function hasAnyPermission(array $slugs)
    {
        if ($this->is_admin) {
            return true;
        }
        
        return $this->permissions()->whereIn('slug', $slugs)->exists();
    }

    public function hasAllPermissions(array $slugs)
    {
        if ($this->is_admin) {
            return true;
        }
        
        $count = $this->permissions()->whereIn('slug', $slugs)->count();
        return $count === count($slugs);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    
    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
    
    public function socialMediaPosts()
    {
        return $this->hasMany(SocialMediaPost::class);
    }


}
