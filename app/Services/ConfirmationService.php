<?php

namespace App\Services;

use App\Models\Confirmation;
use App\Notifications\ConfirmationNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ConfirmationService
{


    public function generateAndSend(string $setting_id, string $confirmationMethod)
    {
        $code = rand(100000, 999999);
        $expiryTime = Carbon::now()->addMinutes(10);
        $ConfirmationCode = $this->sendConfirmationCode($code, $confirmationMethod);
        // if success send message
        if ($ConfirmationCode)
            Confirmation::create(['user_setting_id' => $setting_id, 'code' => $code, 'expiry_time' => $expiryTime, 'confirmation_method' => $confirmationMethod]);
        return $ConfirmationCode;
    }
    public function validateCode(string $setting_id, string $confirmation_code)
    {
        $confirmationCode = Confirmation::where(['user_setting_id' => $setting_id, 'code' => $confirmation_code])->first();
        if (!$confirmationCode)
            return 'Invalid confirmation code';
        $expiryTime = Carbon::parse($confirmationCode->expiry_time);
        if ($expiryTime->isPast())
            return 'Confirmation code has expired';
        $confirmationCode->is_success = true;
        $confirmationCode->save();
        return 'Ok!';
    }
    public function sendConfirmationCode($code, $confirmationMethod)
    {
        // we can use this for sending if we in production 
        //$confirmation_service = new ConfirmationNotification();
        $messageAndResult = 'Your confirmation code is: ' . $code;
        switch ($confirmationMethod) {
            case 'sms':
                //logic Sending here SMS... 
                $messageAndResult .= ' Send to your phone "' . Auth::user()->phone_number.'"';
                break;
            case 'email':
                // logic Sending here email...
                $messageAndResult .= ' Send to your email "' . Auth::user()->email.'"';
                break;
            case 'telegram':
                // logic Sending here message...
                $messageAndResult .= ' Send to your telegram "@' . Auth::user()->telegram.'"';
                break;
        }
        //return message if success or error 
        return $messageAndResult;
    }
}
