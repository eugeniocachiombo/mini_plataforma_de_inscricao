<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        if (count($users) == 0) {
            return response()->json(["message" => "Nenhuma informação encontrada"], 404);
        }
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            "name" => "required|string|min:3",
            "email" => "required|email|unique:users,email",
            "password" => "required",
        ];

        $messages = [
            "name.required" => "O nome é obrigatório",
            "name.string" => "O nome deve ser letras",
            "name.min" => "deve conter 3 caracteres no mínimo",

            "email.required" => "O email é obrigatório",
            "email.email" => "Somente textos em formato de email",
            "email.unique" => "Já existe um email com este número",

            "password.required" => "A palavra-passe é obrigatória",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        User::create($validator->validated());
        return response()->json(["message" => "Candidato cadastrado com sucesso."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(["message" => "Candidato não encontrado"], 404);
        }
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(["message" => "Candidato não encontrado"], 404);
        }

        $rules = [
            "name" => "required|string|min:3",
            "email" => "required|email|unique:users,email,".$id,
        ];

        $messages = [
            "name.required" => "O nome é obrigatório",
            "name.string" => "O nome deve ser letras",
            "name.min" => "deve conter 3 caracteres no mínimo",

            "email.required" => "O email é obrigatório",
            "email.email" => "Somente textos em formato de email",
            "email.min" => "Já existe um email com este número",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        User::where("id", $id)->update($validator->validated());
        return response()->json(["message" => "Informações actualizadas com sucesso."], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(["message" => "Candidato não encontrado"], 404);
        }
        $user->delete();
        return response()->json(["message" => "Candidato eliminado com sucesso."], 204);
    }

    public function login(Request $request){
        $credencials = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        if (Auth::attempt($credencials)) {
            $token = $request->user()->createToken('api_token');
            return response()->json([
                'access_token' => $token->plainTextToken,
                'type_token' => "bearer",
            ], 200);
        }

        return response()->json(['message' => "Credenciais não encontradas"], 404);
    }
}
