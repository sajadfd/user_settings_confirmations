<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSetting;
use App\Services\ConfirmationService;
use App\Services\UserSettingService;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{


    public function index(User $user)
    {
        $settings = $user->userSettings;
        return view('settings.index', compact('user', 'settings'));
    }
    public function create(User $user)
    {
        return view('settings.create', compact('user'));
    }
    public function store(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'value' => 'required|string',
            // 'method' => 'required|string'
        ]);
        $setting = new UserSetting([
            'name' => $request->input('name'),
            'value' => $request->input('value')
        ]);
        $user->userSettings()->save($setting);
        // $confirmation_service = new ConfirmationService();
        // $confirmationCode =  $confirmation_service->generate($user);
        // $setting->update(['confirmation_code' => $confirmationCode]);
        return redirect()->route('settings.index', $user);
    }
    public function edit(User $user, UserSetting $setting)
    {
        return view('settings.edit', compact('user', 'setting'));
    }
    public function update(Request $request, User $user, UserSetting $setting)
    {
        $request->validate([
            'name' => 'required|string',
            'value' => 'required|string',
            'method' => 'required|string'
            // 'confirmation_code' => 'required|string'
        ]);
        // Implement the logic for verifying the confirmation code here

        $confirmation_service = new ConfirmationService();
        $confirmationCode =  $confirmation_service->generate($user);

        // $confirmationCode = $request->input('confirmation_code');

        // if ($setting->confirmation_code !== $confirmationCode) {
        return back()->withErrors(['confirmation_code' => 'Invalid confirmation code']);
        // }
        $setting->update(['value' => $request->input('value')]);
        return redirect()->route('settings.index', $user);
    }
    public function destroy(User $user, UserSetting $setting)
    {
        $setting->delete();
        return redirect()->route('settings.index', $user);
    }
    public function checkConfirmationCode(Request $request, UserSetting $setting)
    {
        $request->validate([
            'confirmation_code' => 'required|string'
        ]);
        $confirmationCode = $request->input('confirmation_code');
        if ($setting->confirmation_code !== $confirmationCode) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true]);
    }
    // public function show(Request $request, $user_id)
    // {
    //     $user = User::find($user_id);
    //     $user_settings = $user->userSettings;
    //     return view('user_settings.show', compact('user_settings'));
    // }

    // public function update(Request $request, $user_id, $setting_id)
    // {
    //     $confirmation_method = $request->input('confirmation_method');
    //     $new_setting_value = $request->input('new_setting_value');

    //     $user_setting_service = new UserSettingService();
    //     $user_setting_service->updateSetting($user_id, $setting_id, $new_setting_value);

    //     $confirmation_service = new ConfirmationService();
    //     $confirmation_service->generateAndSendConfirmationCode($user_id, $setting_id, $confirmation_method);

    //     return redirect()->back()->with('success', 'Setting updated successfully.');
    // }

    // public function confirm(Request $request, $user_id, $setting_id, $confirmation_code)
    // {
    //     $confirmation_service = new ConfirmationService();
    //     $confirmation_service->confirmCode($user_id, $setting_id, $confirmation_code);

    //     return redirect()->back()->with('success', 'Setting confirmed successfully.');
    // }
}
