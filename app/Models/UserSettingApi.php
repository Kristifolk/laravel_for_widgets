<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSettingApi extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'api_key','user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function doesTheUserHaveApiSettings($user): bool
    {
        $settings = self::where('user_id', $user->id)->first();
        return !empty($settings) && !empty($settings->api_key) && !empty($settings->url);
    }
}
