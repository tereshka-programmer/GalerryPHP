<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfilePostRequest;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegistrationPostRequest;
use App\Models\Review;
use App\Models\User;
use App\Enum\Role;
use App\Services\Auth\AuthenticationUserService;
use App\Services\Auth\UpdateUserService;
use App\Services\Auth\RegistrationUserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * Handle an authentication attempt.
     *
     * @param LoginPostRequest $request
     * @return RedirectResponse
     */
    public function authenticate(LoginPostRequest $request, AuthenticationUserService $authenticationUserService): RedirectResponse
    {
        $validated = $request->validated();
        $authenticationUserService->handle($validated['email'], $validated['password']);
        $request->session()->regenerate();

        return redirect()->route('profile');
    }

    public function authenticateForm(): View
    {
        return view('login');
    }

    public function profileForm(): View
    {
        $reviews = Review::where('user_id', Auth::id())->get();
        return view('profile', ['user' => Auth::user(), 'reviews' => $reviews]);
    }

    public function registration(RegistrationPostRequest $request, RegistrationUserService $registrationUserService): RedirectResponse
    {
//        dd($request);

        $role = $request->input('author') ?  Role::Author: Role::User;

        $registrationUserService->handle(
            $request->input('password'),
            $request->input('email'),
            $request->input('first_name'),
            $request->input('last_name'),
            $role
        );
        return redirect()->route('login');
    }

    public function registrationForm(): View
    {
        return view('registration');
    }

    public function update(UpdateProfilePostRequest $request, UpdateUserService $updateUserService): RedirectResponse
    {
        $request->input('author') ? $role = Role::Author : $role = Role::User;
        $updateUserService->handle(
            $request->input('first_name'),
            $request->input('last_name'),
            $role,
            \auth()->user()
        );

        return redirect()->route('profile');
    }

    public function editForm(): View
    {
        return view('edit-user');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(): View
    {
        return view('registration');
    }

    public function authAdmin(): RedirectResponse
    {
        Auth::login(User::where('email', 'admin@gmail.com')->first());

        return redirect()->route('profile');
    }

    public function authAuthor(): RedirectResponse
    {
        Auth::login(User::where('email', 'author@gmail.com')->first());
        return redirect()->route('profile');
    }

    public function authUser(): RedirectResponse
    {
        Auth::login(User::where('email', 'user@gmail.com')->first());

        return redirect()->route('profile');
    }
}
