<?php

namespace Database\Seeders;

use App\Models\CalidadProducto;
use App\Models\Institucion;
use App\Models\Mercado;
use App\Models\NivelCapacitacion;
use App\Models\OrigenAgua;
use App\Models\TipoCertificacion;
use App\Models\TipoCompania;
use App\Models\TipoEspecializacion;
use App\Models\TipoFinanciamiento;
use App\Models\TipoMaquinaria;
use App\Models\TipoMovilidad;
use App\Models\TipoTransporte;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Institucion::create([
            'inst_nombre' => "Plantas acopiadoras de leche",
            'inst_naturaleza' => "PRIVADO",
            'inst_nivel' => "REGIONAL",

        ]);

        Institucion::create([
            'inst_nombre' => "Cooperativas lecheras",
            'inst_naturaleza' => "PRIVADO",
            'inst_nivel' => "REGIONAL",

        ]);

        Institucion::create([
            'inst_nombre' => "Empresas procesadoras de lácteos",
            'inst_naturaleza' => "PRIVADO",
            'inst_nivel' => "REGIONAL",

        ]);


        Institucion::create([
            'inst_nombre' => "Distribuidoras y mayoristas",
            'inst_naturaleza' => "PRIVADO",
            'inst_nivel' => "REGIONAL",

        ]);

        Institucion::create([
            'inst_nombre' => "Autoridades de regulación y sanidad",
            'inst_naturaleza' => "PRIVADO",
            'inst_nivel' => "REGIONAL",

        ]);

        Institucion::create([
            'inst_nombre' => "Asociaciones y organizaciones del sector lácteo",
            'inst_naturaleza' => "PRIVADO",
            'inst_nivel' => "REGIONAL",

        ]);


        TipoCompania::create([
            'tcomp_nombre' => "Cooperativas lecheras",
        ]);


        TipoCompania::create([
            'tcomp_nombre' => "Plantas acopiadoras de leche",
        ]);


        TipoCompania::create([
            'tcomp_nombre' => "Empresas procesadoras de lácteos",
        ]);



        TipoCertificacion::create([
            'tcer_nombre' => "Certificación de Buenas Prácticas de Manufactura (BPM)",
        ]);

        TipoCertificacion::create([
            'tcer_nombre' => "Certificación HACCP (Análisis de Peligros y Puntos Críticos de Control)",
        ]);

        TipoCertificacion::create([
            'tcer_nombre' => "Certificación de Comercio Justo (Fair Trade)",
        ]);

        TipoCertificacion::create([
            'tcer_nombre' => "Certificación de Calidad Alimentaria ISO 22000",
        ]);

        TipoCertificacion::create([
            'tcer_nombre' => "Certificación de producción orgánica",
        ]);

        TipoCertificacion::create([
            'tcer_nombre' => "Certificación de Buenas Prácticas Agrícolas (BPA)",
        ]);

        TipoCertificacion::create([
            'tcer_nombre' => "Certificación de bienestar animal",
        ]);



        TipoEspecializacion::create([
            'tesp_nombre' => "Especialización en producción lechera",
        ]);

        TipoEspecializacion::create([
            'tesp_nombre' => "Especialización en procesamiento lácteo",
        ]);
        TipoEspecializacion::create([
            'tesp_nombre' => "Especialización en calidad y seguridad alimentaria",
        ]);
        TipoEspecializacion::create([
            'tesp_nombre' => "Especialización en tecnología e innovación láctea",
        ]);
        TipoEspecializacion::create([
            'tesp_nombre' => "Especialización en logística y distribución",
        ]);

        TipoEspecializacion::create([
            'tesp_nombre' => "Especialización en sostenibilidad y responsabilidad social",
        ]);

        TipoEspecializacion::create([
            'tesp_nombre' => "Especialización en marketing y comercialización de productos lácteos",
        ]);

        TipoEspecializacion::create([
            'tesp_nombre' => "Especialización en investigación y desarrollo en lácteos",
        ]);
        TipoEspecializacion::create([
            'tesp_nombre' => "Especialización en regulación y legislación",
        ]);


        CalidadProducto::create([
            'cpro_nombre' => "Malo",
        ]);

        CalidadProducto::create([
            'cpro_nombre' => "Regular",
        ]);

        CalidadProducto::create([
            'cpro_nombre' => "Bueno",
        ]);

        CalidadProducto::create([
            'cpro_nombre' => "Excelente",
        ]);



        TipoTransporte::create([
            'ttra_nombre' => "Transporte por camión cisterna",
        ]);

        TipoTransporte::create([
            'ttra_nombre' => "Transporte en camiones refrigerados",
        ]);

        TipoTransporte::create([
            'ttra_nombre' => "Transporte en tren",
        ]);

        TipoTransporte::create([
            'ttra_nombre' => "Transporte en barco",
        ]);

        TipoTransporte::create([
            'ttra_nombre' => "Transporte en avión",
        ]);


        TipoTransporte::create([
            'ttra_nombre' => "Transporte en contenedores isotérmicos",
        ]);

        TipoTransporte::create([
            'ttra_nombre' => "Transporte en sistemas de distribución urbanos",
        ]);


        
        TipoMovilidad::create([
            'tmov_nombre' => "Camiones cisterna",
        ]);

        TipoMovilidad::create([
            'tmov_nombre' => "Camiones refrigerados",
        ]);

        TipoMovilidad::create([
            'tmov_nombre' => "Furgonetas de reparto",
        ]);

        TipoMovilidad::create([
            'tmov_nombre' => "Carretillas elevadoras",
        ]);


        TipoMovilidad::create([
            'tmov_nombre' => "Tractores",
        ]);

        TipoMovilidad::create([
            'tmov_nombre' => "Remolques o semirremolques",
        ]);

        TipoMovilidad::create([
            'tmov_nombre' => "Carritos y carretas internas",
        ]);

        TipoMovilidad::create([
            'tmov_nombre' => "Vehículos de mantenimiento",
        ]);


        OrigenAgua::create([
            'oagu_nombre' => "Agua superficial",
        ]);

        OrigenAgua::create([
            'oagu_nombre' => "Agua subterránea",
        ]);

        OrigenAgua::create([
            'oagu_nombre' => "Agua atmosférica",
        ]);



        TipoFinanciamiento::create([
            'tfin_nombre' => "Créditos bancarios",
        ]);


        TipoFinanciamiento::create([
            'tfin_nombre' => "Fondos públicos",
        ]);

        TipoFinanciamiento::create([
            'tfin_nombre' => "Programas de promoción de exportaciones",
        ]);

        TipoFinanciamiento::create([
            'tfin_nombre' => "Fondos de desarrollo agrícola",
        ]);

        TipoFinanciamiento::create([
            'tfin_nombre' => "Inversionistas privados",
        ]);

        TipoFinanciamiento::create([
            'tfin_nombre' => "Programas de financiamiento de organismos internacionales",
        ]);

        
        TipoMaquinaria::create([
            'tmaq_nombre' => "Separadores centrífugos",
        ]);

        TipoMaquinaria::create([
            'tmaq_nombre' => "Pasteurizadores",
        ]);

        TipoMaquinaria::create([
            'tmaq_nombre' => "Homogeneizadores",
        ]);

        TipoMaquinaria::create([
            'tmaq_nombre' => "Centrífugas de desnatado",
        ]);

        TipoMaquinaria::create([
            'tmaq_nombre' => "Bacterias lácticas y cultivos iniciadores",
        ]);

        TipoMaquinaria::create([
            'tmaq_nombre' => "Máquinas de llenado y envasado",
        ]);

        TipoMaquinaria::create([
            'tmaq_nombre' => "Tanques de almacenamiento y refrigeración",
        ]);

        TipoMaquinaria::create([
            'tmaq_nombre' => "Máquinas de embalaje y etiquetado",
        ]);
        TipoMaquinaria::create([
            'tmaq_nombre' => "Cortadoras y rebanadoras",
        ]);

        TipoMaquinaria::create([
            'tmaq_nombre' => "Líneas de producción automatizadas",
        ]);

        for ($i = 1; $i < 6; $i++) {

            Mercado::create([
                'merc_nombre' => "MERCADO $i",
            ]);

            NivelCapacitacion::create([
                'ncap_nombre' => "NIVEL CAPACITACION $i",
            ]);
        }

    }
}
