<?php

namespace App\Http\Controllers\Cargo;

use App\Http\Controllers\Controller;
use App\Models\CargoModel;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public  function listar()
    {
        try {
            $cargos = CargoModel::all();
            return response()->json(['cargos' => $cargos], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
