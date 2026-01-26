<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;

class AdminUserPanelController extends Controller
{
     public function index(Request $request)
    {
        $users = Usuario::select('nombre','email','rol_id')->paginate(10);


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

    }
}
