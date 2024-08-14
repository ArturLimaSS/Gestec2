<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EmpresaUserModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'name' => $request->name,
                'cpf' => $request->cpf,
            ]);

            $empresa_user = EmpresaUserModel::create([
                'empresa_id' => $request->empresa_id,
                'user_id' => $user->id,
                'cargo_id' => $request->cargo_id,
            ]);
            DB::commit();
            return response()->json(['message' => 'Usuário criado com sucesso!', 'user' => $user, 'empresa_user' => $empresa_user], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = User::find($request->id);
            if ($user) {
                $user->update($request->all());
                return response()->json(['message' => 'Usuário atualizado com sucesso!', 'user' => $user], 200);
            } else {
                return response()->json(['error' => 'Usuário não encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function list(Request $request)
    {
        try {
            $users = User::whereHas('empresa', function ($query) use ($request) {
                $query->where('tb_empresa.empresa_id', $request->empresa_id);
            })->get();
            return response()->json(['users' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
