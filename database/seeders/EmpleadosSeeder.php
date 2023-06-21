<?php

namespace Database\Seeders;

use App\Models\Empleado;
use App\Models\PlantaEmpleado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmpleadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        Empleado::create([
            'empl_paterno' => 'Quispe',
            'empl_materno' => 'Aguilar',
            'empl_nombres' => 'Francisco',
            'empl_dni' => '0270095',
            'empl_telefono' => '930943797',
            'empl_email' => 'geydy_2517_9@hotmail.com',
            'empl_fecha_nac' => $faker->date('Y-m-d', '-18 years'),
            'empl_sexo' => 'M',
            'empl_fecha_inicio_actividad' =>  $faker->date('Y-m-d', '-2 years'),
            'empl_posi_id' => $faker->numberBetween(1, 5),
            'empl_gins_id' => $faker->numberBetween(1, 5),
            'empl_prof_id' => $faker->numberBetween(1, 5),
            'empl_rdes_id' => $faker->numberBetween(1, 5),
        ]);

        PlantaEmpleado::create([
            'plem_activo' => 1,
            'plem_fecha_alta' => $faker->date('Y-m-d', '-2 years'),
            'plem_responsable' => 1,
            'plem_plan_id' => 1,
            'plem_empl_id' => 1,

        ]);
        
        Empleado::create([
            'empl_paterno' => 'Colquehuanca',
            'empl_materno' => 'Pari',
            'empl_nombres' => 'Fernando ',
            'empl_dni' => '02168660',
            'empl_telefono' => '951011916',
            'empl_email' => $faker->email,
            'empl_fecha_nac' => $faker->date('Y-m-d', '-40 years'),
            'empl_sexo' => 'M',
            'empl_fecha_inicio_actividad' =>  $faker->date('Y-m-d', '-10 years'),
            'empl_posi_id' => $faker->numberBetween(1, 5),
            'empl_gins_id' => $faker->numberBetween(1, 5),
            'empl_prof_id' => $faker->numberBetween(1, 5),
            'empl_rdes_id' => $faker->numberBetween(1, 5),
        ]);

        PlantaEmpleado::create([
            'plem_activo' => 1,
            'plem_fecha_alta' => $faker->date('Y-m-d', '-10 years'),
            'plem_responsable' => 1,
            'plem_plan_id' => 2,
            'plem_empl_id' => 2,

        ]);

        Empleado::create([
            'empl_paterno' => ' Yaguno',
            'empl_materno' => 'Puma',
            'empl_nombres' => 'Uriel ',
            'empl_dni' => '44009446',
            'empl_telefono' => '930943797',
            'empl_email' => 'groupyaguno@gmail.com',
            'empl_fecha_nac' => $faker->date('Y-m-d', '-18 years'),
            'empl_sexo' => 'M',
            'empl_fecha_inicio_actividad' =>  $faker->date('Y-m-d', '-2 years'),
            'empl_posi_id' => $faker->numberBetween(1, 5),
            'empl_gins_id' => $faker->numberBetween(1, 5),
            'empl_prof_id' => $faker->numberBetween(1, 5),
            'empl_rdes_id' => $faker->numberBetween(1, 5),
        ]);

        PlantaEmpleado::create([
            'plem_activo' => 1,
            'plem_fecha_alta' => $faker->date('Y-m-d', '-2 years'),
            'plem_responsable' => 1,
            'plem_plan_id' => 3,
            'plem_empl_id' => 3,

        ]);

        Empleado::create([
            'empl_paterno' => 'Ticona',
            'empl_materno' => 'Quispe',
            'empl_nombres' => 'Sonia  ',
            'empl_dni' => '01302638',
            'empl_telefono' => '914154382',
            'empl_email' => $faker->email,
            'empl_fecha_nac' => $faker->date('Y-m-d', '-18 years'),
            'empl_sexo' => 'F',
            'empl_fecha_inicio_actividad' =>  $faker->date('Y-m-d', '-2 years'),
            'empl_posi_id' => $faker->numberBetween(1, 5),
            'empl_gins_id' => $faker->numberBetween(1, 5),
            'empl_prof_id' => $faker->numberBetween(1, 5),
            'empl_rdes_id' => $faker->numberBetween(1, 5),
        ]);

        PlantaEmpleado::create([
            'plem_activo' => 1,
            'plem_fecha_alta' => $faker->date('Y-m-d', '-2 years'),
            'plem_responsable' => 1,
            'plem_plan_id' => 4,
            'plem_empl_id' => 4,

        ]);

        Empleado::create([
            'empl_paterno' => 'Ancco',
            'empl_materno' => 'Casas',
            'empl_nombres' => 'Wasintong  ',
            'empl_dni' => '02298585',
            'empl_telefono' => '987069165',
            'empl_email' => $faker->email,
            'empl_fecha_nac' => $faker->date('Y-m-d', '-18 years'),
            'empl_sexo' => 'M',
            'empl_fecha_inicio_actividad' =>  $faker->date('Y-m-d', '-2 years'),
            'empl_posi_id' => $faker->numberBetween(1, 5),
            'empl_gins_id' => $faker->numberBetween(1, 5),
            'empl_prof_id' => $faker->numberBetween(1, 5),
            'empl_rdes_id' => $faker->numberBetween(1, 5),
        ]);

        PlantaEmpleado::create([
            'plem_activo' => 1,
            'plem_fecha_alta' => $faker->date('Y-m-d', '-2 years'),
            'plem_responsable' => 1,
            'plem_plan_id' => 5,
            'plem_empl_id' => 5,
        ]);

        Empleado::create([
            'empl_paterno' => 'Pari',
            'empl_materno' => 'Quispe',
            'empl_nombres' => 'Ines',
            'empl_dni' => '11100001',
            'empl_telefono' => '955808068',
            'empl_email' => $faker->email,
            'empl_fecha_nac' => $faker->date('Y-m-d', '-28 years'),
            'empl_sexo' => 'M',
            'empl_fecha_inicio_actividad' =>  $faker->date('Y-m-d', '-2 years'),
            'empl_posi_id' => $faker->numberBetween(1, 5),
            'empl_gins_id' => $faker->numberBetween(1, 5),
            'empl_prof_id' => $faker->numberBetween(1, 5),
            'empl_rdes_id' => $faker->numberBetween(1, 5),
        ]);

        PlantaEmpleado::create([
            'plem_activo' => 1,
            'plem_fecha_alta' => $faker->date('Y-m-d', '-2 years'),
            'plem_responsable' => 1,
            'plem_plan_id' => 6,
            'plem_empl_id' => 6,
        ]);

        Empleado::create([
            'empl_paterno' => 'Mamani ',
            'empl_materno' => 'Mollapaza',
            'empl_nombres' => 'Florentina Mercedes ',
            'empl_dni' => '02018973',
            'empl_telefono' => '900915416',
            'empl_email' => 'libra_w.pe@hotmail.com',
            'empl_fecha_nac' => $faker->date('Y-m-d', '-60 years'),
            'empl_sexo' => 'M',
            'empl_fecha_inicio_actividad' =>  $faker->date('Y-m-d', '-2 years'),
            'empl_posi_id' => $faker->numberBetween(1, 5),
            'empl_gins_id' => $faker->numberBetween(1, 5),
            'empl_prof_id' => $faker->numberBetween(1, 5),
            'empl_rdes_id' => $faker->numberBetween(1, 5),
        ]);

        PlantaEmpleado::create([
            'plem_activo' => 1,
            'plem_fecha_alta' => $faker->date('Y-m-d', '-2 years'),
            'plem_responsable' => 1,
            'plem_plan_id' => 7,
            'plem_empl_id' => 7,
        ]);

    }
}