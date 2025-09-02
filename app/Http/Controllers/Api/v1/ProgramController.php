<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\ProgramResource;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = Program::all();

        if (count($programs) == 0) {
            return response()->json(["message" => "Nenhuma informação encontrada"], 404);
        }
        return ProgramResource::collection($programs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            "description" => "required|string|min:3",
            "startdate"   => "required|date|after_or_equal:today",
            "enddate" => "required|date|after_or_equal:startdate",
            "status"      => "required|in:activo,inactivo",
        ];

        $messages = [
            "description.required" => "A descrição é obrigatória",
            "description.string"   => "A descrição deve conter apenas letras",
            "description.min"      => "A descrição deve conter no mínimo 3 caracteres",

            "startdate.required"   => "A data de início é obrigatória",
            "startdate.date"       => "A data de início deve ser uma data válida",
            "startdate.after_or_equal" => "A data de início deve ser hoje ou posterior",

            "enddate.required"     => "A data de fim é obrigatória",
            "enddate.date"         => "A data de fim deve ser uma data válida",
            "enddate.after_or_equal" => "A data de fim deve ser hoje ou posterior",

            "status.required"      => "O estado é obrigatório",
            "status.in"            => "O estado só pode ser 'activo' ou 'inactivo'",
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Program::create($validator->validated());
        return response()->json(["message" => "Programa cadastrado com sucesso."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json(["message" => "Programa não encontrado"], 404);
        }
        return response()->json($program, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json(["message" => "Programa não encontrado"], 404);
        }

        $rules = [
            "description" => "required|string|min:3",
            "startdate"   => "required|date|after_or_equal:today",
            "enddate" => "required|date|after_or_equal:startdate",
            "status"      => "required|in:activo,inactivo",
        ];

        $messages = [
            "description.required" => "A descrição é obrigatória",
            "description.string"   => "A descrição deve conter apenas letras",
            "description.min"      => "A descrição deve conter no mínimo 3 caracteres",

            "startdate.required"   => "A data de início é obrigatória",
            "startdate.date"       => "A data de início deve ser uma data válida",
            "startdate.after_or_equal" => "A data de início deve ser hoje ou posterior",

            "enddate.required"     => "A data de fim é obrigatória",
            "enddate.date"         => "A data de fim deve ser uma data válida",
            "enddate.after_or_equal" => "A data de fim deve ser hoje ou posterior",

            "status.required"      => "O estado é obrigatório",
            "status.in"            => "O estado só pode ser 'activo' ou 'inactivo'",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Program::where("id", $id)->update($validator->validated());
        return response()->json(["message" => "Informações actualizadas com sucesso."], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json(["message" => "Programa não encontrado"], 404);
        }
        $program->delete();
        return response()->json(["message" => "Programa eliminado com sucesso."], 204);
    }
}
