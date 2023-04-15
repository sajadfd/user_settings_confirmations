<?php

namespace App\Services;

use App\Models\Confirmation;
use App\Notifications\ConfirmationNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ConfirmationService
{
    private $notification;

    public function __construct(ConfirmationNotification $notification)
    {
        $this->notification = $notification;
    }
    public function generateAndSend(string $setting_id, string $confirmationMethod): string
    {
        $validConfirmationCode = Confirmation::where('expiry_time', '>', Carbon::now())->where(['user_setting_id' =>  $setting_id, 'confirmation_method' =>  $confirmationMethod, 'is_success' =>  false])->first();
        if ($validConfirmationCode) {
            return $this->sendConfirmationCode($validConfirmationCode->code, $confirmationMethod);
        }
        $code = rand(100000, 999999);
        $expiryTime = Carbon::now()->addMinutes(10);
        $ConfirmationCode = $this->sendConfirmationCode($code, $confirmationMethod);
        // if success send message we save
        if ($ConfirmationCode) {
            Confirmation::create([
                'user_setting_id' => $setting_id,
                'code' => $code,
                'expiry_time' => $expiryTime,
                'confirmation_method' => $confirmationMethod
            ]);
        }
        return $ConfirmationCode;
    }
    public function validateCode(string $setting_id, string $confirmation_code, string $confirmationMethod): string
    {
        $confirmationCode = Confirmation::where(['user_setting_id' => $setting_id, 'code' => $confirmation_code, 'confirmation_method' => $confirmationMethod, 'is_success' => false])->first();
        $expiryTime = Carbon::parse(optional($confirmationCode)->expiry_time);
        if (!$confirmationCode) {
            return 'Invalid confirmation code';
        } elseif ($expiryTime->isPast()) {
            //if expired we can send new code
            $newGeneratedCode = $this->generateAndSend($confirmationCode->user_setting_id, $confirmationCode->confirmation_method);
            return 'Confirmation code has expired we send new ' . $newGeneratedCode;
        } else {
            $confirmationCode->is_success = true;
            $confirmationCode->save();
            return '';
        }
    }
    public function sendConfirmationCode(int $code, string $confirmationMethod): string
    {
        $user = Auth::user();
        switch ($confirmationMethod) {
            case 'sms':
                $recipient = 'phone "' . $user->phone_number . '"';
                break;
            case 'email':
                $recipient = 'email "' . $user->email . '"';
                break;
            case 'telegram':
                $recipient = 'telegram "@' . $user->telegram . '"';
                break;
            default:
                return 'Invalid confirmation method specified.';
        }
        $message = "Your confirmation code is: $code. Sent to your $recipient.";
        // If we were in production, we could use this line to send the message
        // $this->notification->send($user, $message);
        return $message;
    }
}
