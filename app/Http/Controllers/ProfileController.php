<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update informasi profil, foto, dan password.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Validasi Data
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Nama input file: 'profile_photo'
            'current_password' => ['nullable', 'required_with:password', 'current_password'], 
            'password' => ['nullable', 'confirmed', 'min:8'],
        ];

        $validatedData = $request->validate($rules);
        $userUpdateData = [];

        // 2. LOGIKA UPLOAD FOTO PROFIL (FIX)
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Simpan foto baru dan update path di database
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $userUpdateData['profile_photo_path'] = $path; // <-- Nama kolom di DB harus ini
        }

        // 3. LOGIKA UPDATE PASSWORD
        if ($request->filled('password')) {
            $userUpdateData['password'] = Hash::make($validatedData['password']);
        }

        // 4. UPDATE DATA DASAR (Nama, Email)
        $userUpdateData['name'] = $validatedData['name'];
        $userUpdateData['email'] = $validatedData['email'];
        
        $user->update($userUpdateData);

        // 5. FIX REDIRECT: Redirect ke halaman produk setelah update berhasil
        $redirectRoute = Auth::user()->role_id == 1 ? 'products.index' : 'dashboard'; // Asumsi role_id 1 adalah Admin

        return redirect()
            ->route($redirectRoute)
            ->with('success', 'Profil berhasil diperbarui!');
    }
}