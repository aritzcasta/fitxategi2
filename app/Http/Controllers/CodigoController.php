<?php

namespace App\Http\Controllers;

use App\Models\RegistroCodigo;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class CodigoController extends Controller
{
    public function show(): View
    {
        $codigo = $this->obtenerCodigoActual();

        return view('codigo', ['codigo' => $codigo]);
    }

    public function actual(): JsonResponse
    {
        $codigo = $this->obtenerCodigoActual();

        return response()->json([
            'codigo' => $codigo->codigo,
            'expires_at' => $codigo->expires_at->toIso8601String(),
        ]);
    }

    private function obtenerCodigoActual(): RegistroCodigo
    {
        RegistroCodigo::where('expires_at', '<', Carbon::now())->delete();

        if (RegistroCodigo::count() > 1) {
            RegistroCodigo::query()->delete();
        }

        $codigo = RegistroCodigo::first();

        if (! $codigo || $codigo->expires_at->lte(Carbon::now())) {
            RegistroCodigo::query()->delete();
            $codigo = RegistroCodigo::create([
                'codigo' => (string) random_int(100000, 999999),
                'expires_at' => Carbon::now()->addSeconds(15),
            ]);
        }

        return $codigo;
    }
}
