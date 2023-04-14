<?php

// namespace App\Http\Controllers;

// use App\Models\Confirmation;
// use App\Models\User;
// use Illuminate\Http\Request;

// // class UserController extends Controller
// // {
// //     public function updateSettings(Request $request, User $user)
// //     {
// //         // Validate the request data
// //         $validatedData = $request->validate([
// //             'setting_name' => 'required|string',
// //             'setting_value' => 'required|string',
// //         ]);

// //         // Find the user setting
// //         $userSetting = $user->userSettings()->where('setting_name', $validatedData['setting_name'])->first();

// //         if ($userSetting) {
// //             // Generate a new confirmation code and store it in the database
// //             $confirmationCode = $userSetting->confirmations()->create([
// //                 'code_value' => rand(100000, 999999),
// //                 'expiry_time' => now()->addMinutes(10),
// //                 'confirmation_method' => $user->selected_confirmation_method,
// //             ]);

// //             // Send the confirmation code to the user using the selected confirmation method
// //             switch ($user->selected_confirmation_method) {
// //                 case 'sms':
// //                     // Send SMS code
// //                     break;
// //                 case 'email':
// //                     // Send email code
// //                     break;
// //                 case 'telegram':
// //                     // Send Telegram code
// //                     break;
// //             }

// //             return response()->json([
// //                 'message' => 'Confirmation code sent successfully.',
// //                 'confirmation_code_id' => $confirmationCode->id,
// //             ]);
// //         }

// //         return response()->json([
// //             'message' => 'User setting not found.',
// //         ], 404);
// //     }

// //     public function confirmCode(Request $request, User $user)
// //     {
// //         // Validate the request data
// //         $validatedData = $request->validate([
// //             'confirmation_code_id' => 'required|integer',
// //             'code_value' => 'required|integer',
// //         ]);

// //         // Find the confirmation code
// //         $confirmationCode = Confirmation::findOrFail($validatedData['confirmation_code_id']);

// //         // Check if the confirmation code is valid
// //         if ($confirmationCode->code_value == $validatedData['code_value'] && now() < $confirmationCode->expiry_time) {
// //             // Update the user setting value
// //             $confirmationCode->userSetting->update([
// //                 'setting_value' => $confirmationCode->setting_value,
// //             ]);

// //             // Delete all previous confirmation codes for this user setting
// //             $confirmationCode->userSetting->confirmations()->delete();

// //             return response()->json([
// //                 'message' => 'User setting updated successfully.',
// //             ]);
// //         }

// //         return response()->json([
// //             'message' => 'Invalid or expired confirmation code.',
// //         ], 422);
// //     }
// // }
