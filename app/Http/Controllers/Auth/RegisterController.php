<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\RegistroCodigo;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $empresas = Empresa::orderBy('nombre')->get();

        return view('auth.register', compact('empresas'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuario,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'empresa_id' => ['required', 'integer', 'exists:empresa,id'],
            'fecha_fin' => ['required', 'date'],
            'codigo' => ['required', 'string'],
        ])->after(function ($validator) use ($data) {
            $codigo = $data['codigo'] ?? null;

            $valido = RegistroCodigo::where('codigo', $codigo)
                ->where('expires_at', '>=', Carbon::now())
                ->exists();

            if (! $valido) {
                $validator->errors()->add('codigo', 'El código de registro no es válido o ha caducado.');
            }
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Usuario
     */
    protected function create(array $data)
    {
        $rol = Rol::firstOrCreate(['nombre' => 'Usuario']);

        return Usuario::create([
            'nombre' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'rol_id' => $rol->id,
            'empresa_id' => $data['empresa_id'],
            'fecha_fin' => $data['fecha_fin'],
        ]);
    }
}
