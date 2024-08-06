<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class UserSettingApi extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'api_key','user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

//    public static function isTheUserHaveApiSettings($user): bool
//    {
//        $settings = self::where('user_id', $user->id)->first();
//        return !empty($settings) && !empty($settings->api_key) && !empty($settings->url);
//    }
    /**
     * @throws Exception
     */
    public static function userApiSettings()
    {
        $userSettings = self::where('user_id', Auth::user()->id)->first();

        if (empty($userSettings) || empty($userSettings->api_key) || empty($userSettings->url)){
            throw new Exception('Добавьте настройки API: url клиники и API ключ');
        }

        return $userSettings;
    }
}
