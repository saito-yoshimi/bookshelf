<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)
            ->first();

        if (
            ! $user ||
            ! Hash::check($request->password, $user->password)
        ) {
            return back()
                ->withErrors([
                    'email' => 'メールアドレスまたはパスワードが正しくありません',
                ])
                ->withInput();
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/books');
    }
    

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/books')
            ->with('success', '会員登録が完了しました。');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
