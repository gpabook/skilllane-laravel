<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $lavyuser = $request->user();

        return Inertia::render('Profile/Edit', [
            // 1️ Are they a MustVerifyEmail user?
        'mustVerifyEmail' => $lavyuser instanceof MustVerifyEmail,

            // 2️ Any status flash
        'status'           => session('status'),

            // 3️ Pass just the bits your Vue page needs
        'user' => [
        'name'       => $lavyuser->name,
        'email'       => $lavyuser->email,
        'avatar_url' => $lavyuser->avatar_url, // from your accessor
        ],
    ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        //$validatedData = $request->validated();

        // Fill user model with validated text-based data
       // $user->fill($validatedData);

////////////////////
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // รับไฟล์และสร้างชื่อไม่ซ้ำ
            $file     = $request->file('avatar');
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

            // ย่อรูปเป็น 300×300 แล้วบันทึกไป storage/app/public/avatars
            $image = Image::read($file)
                          ->scale(300, 300)
                          ->save(storage_path('app/public/avatars/'.$filename));

            // อัปเดตข้อมูลผู้ใช้
            $request->user()->update([
                'avatar' => 'avatars/'.$filename,
            ]);
        }
////////////////////
        // If email was changed and needs re-verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save(); // Save all changes

        return Redirect::route('profile.edit')->with('status','Profile updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}