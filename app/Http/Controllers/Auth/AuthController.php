<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmpresaModel;
use App\Models\EmpresaUserModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'cpf' => 'required|string|unique:users',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>  bcrypt($request->password),
                'cpf' => $request->cpf,
            ]);

            $empresa = EmpresaModel::create([
                'responsavel_id' => $user->id,
            ]);

            $empresa_user = EmpresaUserModel::create([
                'empresa_id' => $empresa->empresa_id,
                'user_id' => $user->id,
                'cargo_id' => 2, // Cargo padrão: Gerente
            ]);

            DB::commit();

            return response()->json(['message' => 'Usuário criado com sucesso!', 'user' => $user, 'empresa' => $empresa], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email ou senha inválidos'
            ], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function check(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userData = User::with('empresa')->find($user->id);
        return response()->json(['user' => $userData]);
    }

    public function logout()
    {
        try {
            $user = auth()->user();

            if ($user) {
                $user->tokens()->delete(); // Tokens da erro por conta do intelephense
                return response()->json(['message' => 'Logout realizado com sucesso'], 200);
            } else {
                return response()->json(['error' => 'Usuário não autenticado'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
