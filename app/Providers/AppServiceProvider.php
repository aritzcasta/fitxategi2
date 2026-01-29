<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifica tu correo electrónico')
                ->line('Haz clic en el botón de abajo para verificar tu dirección de correo.')
                ->action('Verificar correo', $url)
                ->line('Si no has creado una cuenta, no necesitas hacer nada más.');
        });
    }
}
