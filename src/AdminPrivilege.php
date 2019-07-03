<?php

namespace BajakLautMalaka\PmiAdmin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use BajakLautMalaka\PmiAdmin\Privilege;

class AdminPrivilege extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['privilege_id'];
    
    public function privilege(): BelongsTo
    {
        return $this->belongsTo(Privilege::class);
    }
}
