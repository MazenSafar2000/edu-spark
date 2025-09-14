<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function dashboard()
    {
        return view('pages.Manager.dashboard');
    }

    public function profile()
    {
        $manager = Auth::user();
        return view('pages.Manager.profile', compact('manager'));
    }

    public function update(Request $request, Manager $manager)
    {
        $manager = Auth::user()->manager;
        $user = $manager->user;

        $validated = $request->validate([
            'Name_ar'     => ['required', 'string', 'max:255'],
            'Name_en'     => ['required', 'string', 'max:255'],
            'National_ID' => [
                'required',
                'string',
                'regex:/^\d{9}$/',
                Rule::unique('users', 'National_ID')->ignore($user->id),
            ],
            'email'       => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password'    => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($validated, $user, $manager) {
            $emailChanged = $validated['email'] !== $user->email;

            $user->name  = ['en' => $validated['Name_en'], 'ar' => $validated['Name_ar']];
            $user->email = $validated['email'];
            $user->National_ID = $validated['National_ID'];

            if ($emailChanged) {
                $user->email_verified_at = null;
            }

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            if ($user->role !== 'manager') {
                $user->role = 'manager';
            }

            $user->save();

            $manager->save();
        });

        Flasher::addSuccess(trans('messages.success'));
        return redirect()->route('manager.profile')->with('status', trans('messages.success'));
    }
}
