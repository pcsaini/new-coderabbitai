<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle user authentication.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        // Validate user input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8'
        ], [
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter valid email',
            'email.exists' => 'Sorry! this email is not registered with us',
            'password' => 'Please enter password',
            'password.min' => 'Password must be at least 8 characters'
        ]);

        if ($validator->fails()) {
            return back()->with(['error' => $validator->errors()->first()]);
        }

        // Get user credentials from the request
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (!auth()->attempt($credentials, $request->remember)) {
            // Redirect back with input and error message
            return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['auth' => 'Invalid credentials']);
        }

        // Redirect to the home page upon successful authentication
        return redirect()->route('home');
    }

    /**
     * Register a new user.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ], [
            'name' => 'Please enter name',
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter valid email',
            'email.unique' => 'Sorry! this email is already registered with us',
            'password' => 'Please enter password',
            'password.min' => 'Password must be at least 8 characters'
        ]);

        if ($validator->fails()) {
            return back()->with(['error' => $validator->errors()->first()]);
        }

        // Create a new user
        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // Log in the new user
        auth()->login($user);

        // Redirect to the home page
        return redirect()->route('home');
    }

    /**
     * Logout the authenticated user.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();
        $request->session()->invalidate();
        return redirect()->route('auth.login');
    }
}
