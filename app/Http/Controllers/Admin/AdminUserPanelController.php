<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AdminUserPanelController extends Controller
{
     public function index(Request $request)
    {
        $users = Usuario::select('id','nombre','email','rol_id')->paginate(10);


        return view('admin.userPanel', ['users'=>$users]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = Usuario::select('nombre', 'email', 'rol_id')
            ->where('nombre', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.userPanel',['users'=>$users]);
    }
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string',
            'email' => 'required|string|',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required',
        ];
        //email|unique:usuario,email

        // 1B Definir mensajes de error ('El campo precio debe ser numérico...')
        $messages = [
            'nombre.required' => 'El nombre de Usuario es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
        $data = $request->all();
        //dd($data);


        $validator = Validator::make($data,$rules,$messages);
        if($validator->fails())
        {
            //dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();

        }

        $user = new Usuario();
        $user->nombre  = $data['nombre'];
        $user->email  = $data['email'];
        $user->password  = Hash::make($data['password']);
        $user->rol_id  = $data['rol_id'];
        //dd($user);
        $user->save();

        session()->flash('success', 'Usuario creado correctamente');
        return redirect()->route('userPanel');

    }
    public function update(Request $request)
    {
        $id = $request->input('id');
       dd($request);
        $rules = [
            'nombre' => 'required|string',
            'email' => 'required|string|',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required',
        ];
        //email|unique:usuario,email

        // 1B Definir mensajes de error ('El campo precio debe ser numérico...')
        $messages = [
            'nombre.required' => 'El nombre de Usuario es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
        $data = $request->all();
        //dd($data);


        $validator = Validator::make($data,$rules,$messages);
        if($validator->fails())
        {
            //dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();

        }

    }
}
