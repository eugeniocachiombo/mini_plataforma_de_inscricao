<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\CandidatureResource;
use App\Models\Candidature;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidature = Candidature::with("user")
            ->with("program")
            ->get();

        if (count($candidature) == 0) {
            return response()->json(["message" => "Nenhuma informação encontrada"], 404);
        }
        return CandidatureResource::collection($candidature);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            "code"       => "required|integer|unique:candidatures,code",
            "program_id" => "required|integer",
            "user_id"    => "required|integer",
        ];

        $messages = [
            "code.required"        => "O código é obrigatório",
            "code.integer"         => "O programa deve ser um número inteiro",
            "code.unique"          => "Já existe uma candidatura com este código",

            "program_id.required"  => "O programa é obrigatório",
            "program_id.integer"   => "O id do programa deve ser um número inteiro",

            "user_id.required"     => "O Candidatura é obrigatório",
            "user_id.integer"      => "O id do Candidatura deve ser um número inteiro",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $program = Program::find($request->program_id);

        if (!$program) {
            return response()->json(["message" => "Programa não encontrado."], 404);
        }

        if ($program->status != "activo") {
            return response()->json(["message" => "Impossível realizar a candidatura, este programa está inactivo."], 404);
        }


        $startdate = Carbon::parse($program->startdate)->format("Y-m-d");
        $enddate = Carbon::parse($program->enddate)->format("Y-m-d");
        $today = Carbon::now()->format("Y-m-d");

        if ($startdate > $today) {
            return response()->json(["message" => "Impossível realizar a candidatura, a data de início do programa deve ser menor ou igual a data de hoje."], 404);
        }

        if ($today > $enddate) {
            return response()->json(["message" => "Impossível realizar a candidatura, a data de fim do programa deve ser maior ou igual a data de hoje."], 404);
        }

        Candidature::create($validator->validated());
        return response()->json(["message" => "Candidatura cadastrada com sucesso."], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $candidature = Candidature::with(['user', 'program'])->find($id);

        if (!$candidature) {
            return response()->json(["message" => "Candidatura não encontrada"], 404);
        }
        return response()->json($candidature, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $candidature = Candidature::find($id);

        if (!$candidature) {
            return response()->json(["message" => "Candidatura não encontrada"], 404);
        }

         $rules = [
            "code"       => "required|integer|unique:candidatures,code,".$id,
            "program_id" => "required|integer",
            "user_id"    => "required|integer",
        ];

        $messages = [
            "code.required"        => "O código é obrigatório",
            "code.integer"         => "O programa deve ser um número inteiro",
            "code.unique"          => "Já existe uma candidatura com este código",

            "program_id.required"  => "O programa é obrigatório",
            "program_id.integer"   => "O id do programa deve ser um número inteiro",

            "user_id.required"     => "O Candidatura é obrigatório",
            "user_id.integer"      => "O id do Candidatura deve ser um número inteiro",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $program = Program::find($request->program_id);

        if (!$program) {
            return response()->json(["message" => "Programa não encontrado."], 404);
        }

        if ($program->status != "activo") {
            return response()->json(["message" => "Impossível realizar a candidatura, este programa está inactivo."], 404);
        }


        $startdate = Carbon::parse($program->startdate)->format("Y-m-d");
        $enddate = Carbon::parse($program->enddate)->format("Y-m-d");
        $today = Carbon::now()->format("Y-m-d");

        if ($startdate > $today) {
            return response()->json(["message" => "Impossível realizar a candidatura, a data de início do programa deve ser menor ou igual a data de hoje."], 404);
        }

        if ($today > $enddate) {
            return response()->json(["message" => "Impossível realizar a candidatura, a data de fim do programa deve ser maior ou igual a data de hoje."], 404);
        }

        $candidature->code = $request->code;
        $candidature->program_id = $request->program_id;
        $candidature->user_id = $request->user_id;
        $candidature->save();
        return response()->json(["message" => "Informações actualizadas com sucesso."], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $candidature = Candidature::find($id);

        if (!$candidature) {
            return response()->json(["message" => "Candidatura não encontrada"], 404);
        }
        $candidature->delete();
        return response()->json(["message" => "Candidatura eliminada com sucesso."], 204);
    }
}
