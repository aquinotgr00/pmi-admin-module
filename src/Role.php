<?php

namespace BajakLautMalaka\PmiAdmin;

use Illuminate\Database\Eloquent\Model;
use BajakLautMalaka\PmiAdmin\RolePrivilege;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    public function privileges(): HasMany
    {
        return $this->hasMany(RolePrivilege::class);
    }
}
