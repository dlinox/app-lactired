<?php

namespace Database\Seeders;

use App\Models\Planta;
use App\Models\TipoEmpresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlantasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //INSTITUCIONES
        TipoEmpresa::create(['temp_nombre' => "Propiedad Individual",]);
        TipoEmpresa::create(['temp_nombre' => "Cooperativa",]);
        TipoEmpresa::create(['temp_nombre' => "Planta Municipal",]);

        //PLANTAS
        Planta::create([
            'plan_razon_social' => 'Agroindustrias San Francisco Sinty Mayo  EIRL',
            'plan_ruc' => '20448625819',
            'plan_tipo_planta' => 'A',
            'plan_marca' => 'SM',
            'plan_registro_sanitario' => 1,
            'plan_marca_registrada' => 1,
            'plan_tecnificacion' => 1,
            'plan_parametros_digesa' => 1,
            'plan_parametros_produccion' => 1,
            'plan_capacitacion_tdd' => 1,
            'plan_tcomp_id' => 2,
            'plan_ubig_id' => 2,
            'plan_ncap_id' => 3,
            'plan_cpro_id' => 3,
            'plan_inst_id' => 4,
        ]);
        Planta::create([
            'plan_razon_social' => 'Agroindustrias  Chrysef',
            'plan_tipo_planta' => 'A',
            'plan_ruc' => '10021686609',
            'plan_marca' => 'SM',
            'plan_registro_sanitario' => 1,
            'plan_marca_registrada' => 0,
            'plan_tecnificacion' => 1,
            'plan_parametros_digesa' => 1,
            'plan_parametros_produccion' => 1,
            'plan_capacitacion_tdd' => 1,
            'plan_tcomp_id' => 2,
            'plan_ubig_id' => 2,
            'plan_ncap_id' => 3,
            'plan_cpro_id' => 3,
            'plan_inst_id' => 4,
        ]);
        Planta::create([
            'plan_razon_social' => 'Grupo Yaguno S.A.C',
            'plan_tipo_planta' => 'A',
            'plan_ruc' => '20448661025',
            'plan_marca' => 'SM',
            'plan_registro_sanitario' => 1,
            'plan_marca_registrada' => 0,
            'plan_tecnificacion' => 1,
            'plan_parametros_digesa' => 1,
            'plan_parametros_produccion' => 1,
            'plan_capacitacion_tdd' => 1,
            'plan_tcomp_id' => 2,
            'plan_ubig_id' => 2,
            'plan_ncap_id' => 3,
            'plan_cpro_id' => 3,
            'plan_inst_id' => 4,
        ]);

        

        Planta::create([
            'plan_razon_social' => 'Cooperativa de Servicios de San Santiago',
            'plan_tipo_planta' => 'A',
            'plan_ruc' => '20448766471',
            'plan_marca' => 'SM',
            'plan_registro_sanitario' => 1,
            'plan_marca_registrada' => 1,
            'plan_tecnificacion' => 1,
            'plan_parametros_digesa' => 1,
            'plan_parametros_produccion' => 1,
            'plan_capacitacion_tdd' => 1,
            'plan_tcomp_id' => 2,
            'plan_ubig_id' => 2,
            'plan_ncap_id' => 3,
            'plan_cpro_id' => 3,
            'plan_inst_id' => 4,
        ]);

        Planta::create([
            'plan_razon_social' => 'Ecolacteos Huata ',
            'plan_tipo_planta' => 'A',
            'plan_ruc' => '20172856960',
            'plan_marca' => 'SM',
            'plan_registro_sanitario' => 1,
            'plan_marca_registrada' => 1,
            'plan_tecnificacion' => 1,
            'plan_parametros_digesa' => 1,
            'plan_parametros_produccion' => 1,
            'plan_capacitacion_tdd' => 1,
            'plan_tcomp_id' => 2,
            'plan_ubig_id' => 2,
            'plan_ncap_id' => 3,
            'plan_cpro_id' => 3,
            'plan_inst_id' => 4,
        ]);
        Planta::create([
            'plan_razon_social' => 'Cooperativa de Servicios Copagro Cabana Ltda',
            'plan_tipo_planta' => 'A',
            'plan_ruc' => '20448791310',
            'plan_marca' => 'SM',
            'plan_registro_sanitario' => 1,
            'plan_marca_registrada' => 0,
            'plan_tecnificacion' => 1,
            'plan_parametros_digesa' => 1,
            'plan_parametros_produccion' => 1,
            'plan_capacitacion_tdd' => 1,
            'plan_tcomp_id' => 2,
            'plan_ubig_id' => 2,
            'plan_ncap_id' => 3,
            'plan_cpro_id' => 3,
            'plan_inst_id' => 4,
        ]);
        Planta::create([
            'plan_razon_social' => 'Asociacion de centro de acopio y procesamiento Planta Quesera Florentina',
            'plan_tipo_planta' => 'B',
            'plan_ruc' => '10000000000',
            'plan_marca' => 'SM',
            'plan_registro_sanitario' => 0,
            'plan_marca_registrada' => 0,
            'plan_tecnificacion' => 1,
            'plan_parametros_digesa' => 1,
            'plan_parametros_produccion' => 1,
            'plan_capacitacion_tdd' => 1,
            'plan_tcomp_id' => 2,
            'plan_ubig_id' => 2,
            'plan_ncap_id' => 3,
            'plan_cpro_id' => 3,
            'plan_inst_id' => 4,
        ]);
    }
}
