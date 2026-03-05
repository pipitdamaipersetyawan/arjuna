<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Actions\Fortify\LoginResponse;
use App\Actions\Fortify\LogoutResponse as CustomLogoutResponse;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Redirect setelah login
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);

        // Redirect setelah logout
        $this->app->singleton(LogoutResponse::class, CustomLogoutResponse::class);
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);

        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);

        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::redirectUserForTwoFactorAuthenticationUsing(
            RedirectIfTwoFactorAuthenticatable::class
        );

        // ✅ RATE LIMIT LOGIN
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(
                Str::lower($request->input(Fortify::username())) . '|' . $request->ip()
            );

            return Limit::perMinute(5)->by($throttleKey);
        });

        // ✅ RATE LIMIT 2FA
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->session()->get('login.id')
            );
        });
    }
}