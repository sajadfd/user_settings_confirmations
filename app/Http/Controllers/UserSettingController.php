<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSetting;
use App\Services\ConfirmationService;
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
        ]);
        $setting = new UserSetting([
            'name' => $request->input('name'),
            'value' => $request->input('value')
        ]);
        $user->userSettings()->save($setting);
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
        ]);
        $setting->update(['value' => $request->input('value'), 'name' => $request->input('name')]);
        return redirect()->route('settings.index', $user);
    }
    public function destroy(User $user, UserSetting $setting)
    {
        $setting->delete();
        return redirect()->route('settings.index', $user);
    }
    public function sendConfirmationCode(Request $request)
    {
        $request->validate([
            'confirmationMethod' => 'required|string|in:sms,email,telegram',
            'setting_id' => 'required'
        ]);
        $confirmation_service = new ConfirmationService();
        $confirmationCode =  $confirmation_service->generateAndSend($request->setting_id, $request->confirmationMethod);
        if (!$confirmationCode)
            return response()->json(['success' => false]);
        return response()->json(['success' => true, 'message' => $confirmationCode]);
    }
    public function checkConfirmationCode(Request $request)
    {
        $request->validate([
            'confirmation_code' => 'required|integer|digits:6',
            'setting_id' => 'required'
        ]);
        $confirmation_service = new ConfirmationService();
        $validateCode =  $confirmation_service->validateCode($request->setting_id, $request->confirmation_code);
        if (!$validateCode)
            return response()->json(['success' => false]);
        return response()->json(['success' => true, 'message' => $validateCode]);
    }
}
