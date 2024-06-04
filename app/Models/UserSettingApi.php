<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSettingApi extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'api_key',];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
