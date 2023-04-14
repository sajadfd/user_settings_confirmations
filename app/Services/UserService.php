<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserSetting;
use App\Models\Confirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ConfirmationNotification;

class UserService
{

    public function create(array $userData)
    {
        return User::create($userData);
    }

    public function update(User $user, array $userData)
    {
        $user->update($userData);
        return $user;
    }

    public function delete(User $user)
    {
        $user->delete();
    }


    // public function changeSetting(User $user, UserSetting $user_setting, string $confirmation_method)
    // {
    //     // Generate a confirmation code
    //     $confirmation_code = $this->generateConfirmationCode();

    //     // Create a Confirmation model and associate it with the UserSetting model
    //     $confirmation = new Confirmation([
    //         'code_value' => $confirmation_code,
    //         'expiry_time' => now()->addMinutes(10),
    //         'confirmation_method' => $confirmation_method,
    //     ]);
    //     $user_setting->confirmations()->save($confirmation);

    //     // Send the confirmation code to the user using the selected confirmation method
    //     if ($confirmation_method == 'sms') {
    //         // send SMS
    //     } elseif ($confirmation_method == 'email') {
    //         // send email
    //         Mail::to($user->email)->send(new ConfirmationNotification($confirmation));
    //     } elseif ($confirmation_method == 'telegram') {
    //         // send telegram message
    //         Notification::send($user, new ConfirmationNotification($confirmation));
    //     }
    // }

    // private function generateConfirmationCode()
    // {
    //     // Generate a 6-digit random confirmation code
    //     return rand(100000, 999999);
    // }
}
