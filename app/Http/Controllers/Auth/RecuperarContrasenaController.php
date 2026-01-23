<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class RecuperarContrasenaController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Mostrar el formulario para recuperar la contraseña.
     */
    public function showLinkRequestForm(Request $request)
    {
        return view('auth.passwords.email');
    }
}
