<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username_or_no_pelanggan' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = ['password' => $this->input('password')];

        // Determine the role based on input
        if ($this->input('role') === 'admin') {
            $credentials['username'] = $this->input('username_or_no_pelanggan');
        } else {
            // For 'pelanggan' role, find the user by 'no_pelanggan'
            $pelanggan = Pelanggan::where('no_pelanggan', $this->input('username_or_no_pelanggan'))->first();

            if (!$pelanggan) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'username_or_no_pelanggan' => trans('auth.failed'),
                ]);
            }

            $user = User::find($pelanggan->user_id);

            if (!$user) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'username_or_no_pelanggan' => trans('auth.failed'),
                ]);
            }

            $credentials['username'] = $user->username;
        }

        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'username_or_no_pelanggan' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username_or_no_pelanggan' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('username_or_no_pelanggan')) . '|' . $this->ip());
    }
}
