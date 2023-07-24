<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\GradoInstruccion;
use App\Models\Posicion;
use App\Models\Profesion;
use App\Models\RolDesempenio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrabajadoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cargo::create(['carg_nombre' => "Operario de producción"]);
        Cargo::create(['carg_nombre' => "Técnico de laboratorio"]);
        Cargo::create(['carg_nombre' => "Ingeniero de procesos"]);
        Cargo::create(['carg_nombre' => "Ingeniero de alimentos"]);
        Cargo::create(['carg_nombre' => "Técnico en mantenimiento"]);
        Cargo::create(['carg_nombre' => "Encargado de logística y distribución"]);
        Cargo::create(['carg_nombre' => "Especialista en control de calidad"]);
        Cargo::create(['carg_nombre' => "Gerente de producción"]);
        Cargo::create(['carg_nombre' => "Gerente de ventas y marketing"]);
        Cargo::create(['carg_nombre' => "Gerente de recursos humanos"]);
        Cargo::create(['carg_nombre' => "Analista de costos"]);
        Cargo::create(['carg_nombre' => "Jefe de control de calidad"]);
        Cargo::create(['carg_nombre' => "Ingeniero de seguridad industrial"]);
        Cargo::create(['carg_nombre' => "Ingeniero de automatización"]);
        Cargo::create(['carg_nombre' => "Especialista en compras"]);
        Cargo::create(['carg_nombre' => "Encargado de control de inventario"]);
        Cargo::create(['carg_nombre' => "Coordinador de exportaciones"]);
        Cargo::create(['carg_nombre' => "Analista de mercados"]);
        Cargo::create(['carg_nombre' => "Gerente de calidad y seguridad alimentaria"]);
        Cargo::create(['carg_nombre' => "Coordinador de mantenimiento"]);
        Cargo::create(['carg_nombre' => "Especialista en marketing digital"]);
        Cargo::create(['carg_nombre' => "Técnico en empaque y etiquetado"]);

        GradoInstruccion::create(['gins_nombre' => "Educación Inicial"]);
        GradoInstruccion::create(['gins_nombre' => "Educación Primaria"]);
        GradoInstruccion::create(['gins_nombre' => "Educación Secundaria"]);
        GradoInstruccion::create(['gins_nombre' => "Educación Técnico-Productiva"]);
        GradoInstruccion::create(['gins_nombre' => "Educación Superior"]);
        GradoInstruccion::create(['gins_nombre' => "Educación Superior no Universitaria"]);

        Profesion::create(['prof_nombre' => "Ingeniero de Alimentos"]);
        Profesion::create(['prof_nombre' => "Ingeniero Agrónomo"]);
        Profesion::create(['prof_nombre' => "Tecnólogo en Alimentos"]);
        Profesion::create(['prof_nombre' => "Químico Farmacéutico"]);
        Profesion::create(['prof_nombre' => "Veterinario"]);
        Profesion::create(['prof_nombre' => "Administrador de Empresas"]);
        Profesion::create(['prof_nombre' => "Economista Agrícola"]);
        Profesion::create(['prof_nombre' => "Nutricionista"]);
        Profesion::create(['prof_nombre' => "Ingeniero Mecánico"]);
        Profesion::create(['prof_nombre' => "Especialista en Control de Calidad"]);
        Profesion::create(['prof_nombre' => "Especialista en Logística y Distribución"]);
        Profesion::create(['prof_nombre' => "Ingeniero Ambiental"]);
        Profesion::create(['prof_nombre' => "Ingeniero de Sistemas"]);
        Profesion::create(['prof_nombre' => "Ingeniero en Seguridad Alimentaria"]);
        Profesion::create(['prof_nombre' => "Técnico en Refrigeración y Climatización"]);
        Profesion::create(['prof_nombre' => "Biólogo"]);
        Profesion::create(['prof_nombre' => "Ingeniero en Automatización Industrial"]);

        for ($i = 1; $i < 6; $i++) {
            RolDesempenio::create(['rdes_nombre' => "Rol desempeñado $i"]);
        }
    }
}
