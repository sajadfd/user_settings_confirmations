<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserSetting;
use App\Models\Confirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ConfirmationNotification;

class UserSettingsService
{

    public function get(User $user)
    {
        return $user->settings;
    }

    public function update(User $user, string $key, string $value)
    {
        $user->userSettings()->updateOrCreate(['setting_key' => $key], ['setting_value' => $value]);
    }

    public function delete(User $user, string $key)
    {
        $user->userSettings()->where('setting_key', $key)->delete();
    }

     
}
