<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        $this->new("Programa de Bolsas de Estudo", "2025-09-02", "2025-10-01", "activo");
        $this->new("Programa de Estágio Internacional", "2025-03-01", "2025-04-15", "activo");
        $this->new("Formação em Tecnologia e Inovação", "2025-05-10", "2025-06-20", "inactivo");
        $this->new("Concurso Nacional de Empreendedorismo", "2025-07-05", "2025-08-30", "activo");
        $this->new("Programa de Intercâmbio Académico", "2025-09-15", "2025-12-15", "activo");
        $this->new("Bolsa de Investigação Científica", "2026-01-10", "2026-02-28", "inactivo");
        $this->new("Programa Jovens Líderes", "2025-02-01", "2025-03-01", "activo");
        $this->new("Curso Intensivo de Programação", "2025-04-05", "2025-05-25", "activo");
        $this->new("Programa de Mobilidade Académica", "2025-06-01", "2025-07-31", "inactivo");
        $this->new("Curso Avançado de Inteligência Artificial", "2026-08-20", "2026-09-25", "activo");
    }

    public function new($description, $startdate, $enddate, $status)
    {
        Program::create([
            "description" => $description,
            "startdate" => $startdate,
            "enddate" => $enddate,
            "status" => $status
        ]);
    }
}
