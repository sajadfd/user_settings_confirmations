<?php

namespace App\Services;

use App\Models\Confirmation;
use App\Models\User;
use App\Models\UserSetting;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ConfirmationService
{


    public function generate(User $user)
    {
        $code = rand(100000, 999999);
        // $confirmationCode = UserSetting::create(['user_id' => $user->id, 'code' => $code]);
        // send confirmation code through the user's preferred method
        return $code;
    }

    public function validate(User $user, string $code, string $type)
    {
        $confirmationCode = UserSetting::where(['user_id' => $user->id, 'confirmation_code' => $code])->first();
        if (!$confirmationCode) {
            throw new Exception('Invalid confirmation code');
        }
        $confirmationCode->delete();
    }

    public function sendConfirmationCode(UserSetting $userSetting, $code)
    {
        $message = 'Your confirmation code is: ' . $code;
        switch ($userSetting->user->confirmation_method) {
            case 'sms':
                // Send SMS
                $message .= ' Send to SMS';
                break;
            case 'email':
                // Send email
                $message .= ' Send to email';
                break;
            case 'telegram':
                // Send telegram message
                $message .= ' Send to telegram';
                break;
        }
        return $message;
    }

    // public function generateAndSendConfirmationCode($user_id, $setting_id, $confirmation_method)
    // {
    //     $user_setting = UserSetting::where('user_id', $user_id)
    //         ->where('id', $setting_id)
    //         ->firstOrFail();

    //     $confirmation = new Confirmation();
    //     $confirmation->code_value = rand(1000

    //  public function generateConfirmationCode(UserSetting $userSetting)
    // {
    //     // Generate a random code
    //     $code = rand(100000, 999999);

    //     // Save the code to the database
    //     $confirmation = new Confirmation();
    //     $confirmation->code = $code;
    //     $confirmation->user_setting_id = $userSetting->id;
    //     $confirmation->method = $userSetting->user->confirmation_method;
    //     $confirmation->expires_at = now()->addMinutes(10);
    //     $confirmation->save();

    //     // Send the confirmation code to the user
    //     $this->sendConfirmationCode($userSetting, $code);
    // }
    // public function validateConfirmationCode(UserSetting $userSetting, $code)
    // {
    //     // Retrieve all the confirmation codes for the user setting
    //     $confirmationCodes = $userSetting->confirmationCodes;

    //     // Check if the provided code matches any of the confirmation codes
    //     foreach ($confirmationCodes as $confirmation) {
    //         if ($confirmation->code == $code && $confirmation->expires_at > now()) {
    //             // Code is valid
    //             $confirmation->delete();
    //             return true;
    //         }
    //     }

    //     // Code is not valid
    //     return false;
    // }
    // public function sendConfirmationCode(UserSetting $userSetting, $code)
    // {
    //     $message = 'Your confirmation code is: ' . $code;

    //     switch ($userSetting->user->confirmation_method) {
    //         case 'sms':
    //             // Send SMS
    //             break;
    //         case 'email':
    //             // Send email
    //             break;
    //         case 'telegram':
    //             // Send telegram message
    //             break;
    //     }
    // }
}
