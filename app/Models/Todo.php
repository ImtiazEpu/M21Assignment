<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['task', 'is_complete', 'user_id'];

    /**
     * @return BelongsTo
     */
    public function user(  ): BelongsTo {
        return $this->belongsTo( User::class );
    }
}
