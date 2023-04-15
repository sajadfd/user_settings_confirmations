<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSetting;
use App\Services\ConfirmationService;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    protected $confirmationService;
    public function __construct(ConfirmationService $confirmationService)
    {
        $this->confirmationService = $confirmationService;
    }
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
        $validated = $request->validate([
            'name' => 'required|string',
            'value' => 'required|string',
        ]);
        $user->userSettings()->create($validated);
        return redirect()->route('settings.index', $user);
    }
    public function edit(User $user, UserSetting $setting)
    {
        return view('settings.edit', compact('user', 'setting'));
    }
    public function update(Request $request, User $user, UserSetting $setting)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'value' => 'required|string',
        ]);
        $setting->update($validated);
        return redirect()->route('settings.index', $user);
    }
    public function destroy(User $user, UserSetting $setting)
    {
        $setting->delete();
        return redirect()->route('settings.index', $user);
    }
    public function sendConfirmationCode(Request $request)
    {
        $validated = $request->validate([
            'confirmationMethod' => 'required|string|in:sms,email,telegram',
            'setting_id' => 'required'
        ]);
        $confirmationCode = $this->confirmationService->generateAndSend($validated['setting_id'], $validated['confirmationMethod']);
        if (!$confirmationCode) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true, 'message' => $confirmationCode]);
    }
    public function checkConfirmationCode(Request $request)
    {
        $validated = $request->validate([
            'confirmation_code' => 'required|integer|digits:6',
            'setting_id' => 'required',
            'confirmationMethod' => 'required|string|in:sms,email,telegram',
        ]);
        $validateCode = $this->confirmationService->validateCode($validated['setting_id'], $validated['confirmation_code'], $validated['confirmationMethod']);
        if ($validateCode) {
            return response()->json(['success' => false, 'message' => $validateCode]);
        }
        return response()->json(['success' => true, 'message' =>'Ok !']);
    }
}
