<?php

namespace BajakLautMalaka\PmiAdmin;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use BajakLautMalaka\PmiAdmin\AdminPrivilege;
use BajakLautMalaka\PmiAdmin\Role;
use BajakLautMalaka\PmiDonatur\Campaign;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;
    /**
     * @var array
     */
    
    protected $fillable = ['name', 'email', 'role_id', 'password','active'];
    /**
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Global Scope - sort by latest
     */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->latest();
        });
    }
    
    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    
    public function setPasswordAttribute(string $pass): void
    {

        $this->attributes['password'] = bcrypt($pass);
    }
    
    public function privileges(): HasMany
    {
        return $this->hasMany(AdminPrivilege::class);
    }
    
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class)->withDefault(['name'=>'Custom']);
    }
    
    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }
}
