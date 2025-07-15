<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomLoginController extends Controller
{
    public function showStudentParentLogin()
    {
        return view('auth.login-student-parent');
    }

    public function showTeacherManagerLogin()
    {
        return view('auth.login-teacher-manager');
    }

    public function loginStudent(Request $request)
    {
        return $this->loginWithRole($request, 'student', 'student.dashboard');
    }

    public function loginParent(Request $request)
    {
        return $this->loginWithRole($request, 'parent', 'parent.dashboard');
    }

    public function loginTeacher(Request $request)
    {
        return $this->loginWithRole($request, 'teacher', 'teacher.dashboard');
    }

    public function loginManager(Request $request)
    {
        return $this->loginWithRole($request, 'manager', 'manager.dashboard');
    }

    protected function loginWithRole(Request $request, $role, $redirectRoute)
    {
        $credentials = $request->only('email', 'password');
        $credentials['role'] = $role;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route($redirectRoute);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials or role mismatch.',
        ]);
    }
}
