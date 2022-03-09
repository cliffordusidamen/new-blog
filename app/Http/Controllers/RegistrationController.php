<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * Display registration page
     *
     * @return View
     */
    public function index(): View
    {
        return view('registration/index');
    }

    /**
     * Process registration form submission
     *
     * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = collect($request->validated())
            ->only(['name', 'email', 'password'])
            ->toArray();
        $user = User::create($data);

        if ($user) {
            return back()->with([
                'status' => 'success',
                'message' => 'Registration successful!',
            ]);
        }

        return back()
            ->withInput()
            ->with([
                'status' => 'warning',
                'message' => 'Registration failed. Please, try again',
            ]);
    }
}
