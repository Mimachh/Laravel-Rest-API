<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\SitePolicy;
use App\Policies\UpdateUserPolicy;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\User' => 'App\Policies\UpdateUserPolicy',
        'App\Models\User' => 'App\Policies\SoftDeleteUserPolicy',
        'App\Models\User' => 'App\Policies\RestoreUserPolicy',
        User::class => UpdateUserPolicy::class,

        // 'App\Models\Site' => 'App\Policies\SitePolicy',
        Site::class => SitePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        // VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
        //     $verifyUrl = "http://localhost:5173?email_verify_url=" . $url;
            
        //     return (new MailMessage)
        //     ->subject('Verify Email Address')
        //     ->line('Click the button below to verify your email address.')
        //     ->action('Verify Email Address', $verifyUrl);
        // });

        //
    }
}
