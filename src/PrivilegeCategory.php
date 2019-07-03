<?php

namespace BajakLautMalaka\PmiAdmin;

use Illuminate\Database\Eloquent\Model;
use BajakLautMalaka\PmiAdmin\Privilege;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrivilegeCategory extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name'];
    
    public function privileges(): HasMany
    {
        return $this->hasMany(Privilege::class);
    }
}
