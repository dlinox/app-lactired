<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CalidadProducto;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\GradoInstruccion;
use App\Models\Institucion;
use App\Models\Insumo;
use App\Models\Mercado;
use App\Models\NivelCapacitacion;
use App\Models\OrigenAgua;
use App\Models\Planta;
use App\Models\PlantaEmpleado;
use App\Models\Posicion;
use App\Models\Producto;
use App\Models\Profesion;
use App\Models\Proveedor;
use App\Models\RolDesempenio;
use App\Models\TipoCertificacion;
use App\Models\TipoCompania;
use App\Models\TipoComprobante;
use App\Models\TipoEmpresa;
use App\Models\TipoEspecializacion;
use App\Models\TipoFinanciamiento;
use App\Models\TipoMaquinaria;
use App\Models\TipoMovilidad;
use App\Models\TipoProducto;
use App\Models\TipoTransporte;
use App\Models\UnidadMedida;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UbigeoSeeder::class);
        //CONFIGURACIONES
        //EMPRESA
        $this->call(EmpresaSeeder::class);

        $this->call(PlantasSeeder::class);

        $this->call(AlmacenSeeder::class);

        Cliente::create([
            'clie_nombres' => 'Manuel',
            'clie_paterno' => 'Sanchez',
            'clie_materno' => 'Sanchez',
            'clie_tipo_documento' => 'DNI',
            'clie_nro_documento' => '10101010',
            'clie_tipo_persona' => '0',
            'clie_direccion' => 'Av. Siempre vida 192',
            'clie_telefono' => '951205147',
            'clie_correo' => 'manuel@gmail.com',
            'clie_password' => NULL,
        ]);

        Cliente::create([
            'clie_nombres' => 'Mabel',
            'clie_paterno' => 'Paredes',
            'clie_materno' => 'Paredes',
            'clie_tipo_documento' => 'DNI',
            'clie_nro_documento' => '20101010',
            'clie_tipo_persona' => '0',
            'clie_direccion' => 'Av. Siempre vida 192',
            'clie_telefono' => '951205157',
            'clie_correo' => 'mabel@gmail.com',
            'clie_password' => NULL,
        ]);

        Proveedor::create([

            'prov_dni' => '01010101',
            'prov_paterno' => 'Proveedor',
            'prov_materno' => 'Proveedor',
            'prov_nombres' => 'Proveedor',
            'prov_sexo' => 'M',
            'prov_precio_alta' => 20,
            'prov_precio_baja' => 20,
            'prov_latitud' => 1.000,
            'prov_longitud' => 1.00,
            'prov_activo' => 1,
            'prov_plan_id' => 1,
        ]);

        $this->call(TrabajadoresSeeder::class);

        $faker = Faker::create();

        $this->call(EmpleadosSeeder::class);

        for ($i = 8; $i < 15; $i++) {
            Empleado::create([
                'empl_paterno' => $faker->lastName,
                'empl_materno' => $faker->lastName,
                'empl_nombres' => $faker->firstName,
                'empl_dni' => $faker->numberBetween(10000000, 99999999),
                'empl_telefono' => $faker->numberBetween(100000000, 999999999),
                'empl_email' => $faker->email,
                'empl_fecha_nac' => $faker->date('Y-m-d', '-18 years'),
                'empl_sexo' => $faker->randomElement(['M', 'F']),
                'empl_fecha_inicio_actividad' => $faker->date('Y-m-d', '-1 years'),
                'empl_carg_id' => $faker->numberBetween(1, 5),
                'empl_gins_id' => $faker->numberBetween(1, 5),
                'empl_prof_id' => $faker->numberBetween(1, 5),
                // 'empl_rdes_id' => $faker->numberBetween(1, 5),
            ]);

            PlantaEmpleado::create([
                'plem_activo' => 1,
                'plem_fecha_alta' => $faker->date('Y-m-d', '-2 years'),
                'plem_responsable' => 0,
                'plem_plan_id' =>  $faker->numberBetween(1, 7),
                'plem_empl_id' => $i,

            ]);
        }

        //USUARIOS  Y ROLES

        Role::create(['name' => 'Super Admin']);
        $superADmin = User::create([
            'name' => $faker->firstName,
            'paterno' => $faker->lastName,
            'materno' => $faker->lastName,
            'user_plan_nombre' => 'Agroindustrias San Francisco Sinty Mayo  EIRL',
            'rol_name' => 'Super Admin',
            'dni' => $faker->numberBetween(10000000, 99999999),
            'email' => 'super_admin@gmail.com',
            'password' => 'password',
            'user_plan_id' => 1,
        ]);

        $superADmin->assignRole('Super Admin');


        $this->call(RolsSeeder::class);

        $user = User::create([
            'name' => $faker->firstName,
            'paterno' => $faker->lastName,
            'materno' => $faker->lastName,
            'dni' => $faker->numberBetween(10000000, 99999999),
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'user_plan_nombre' => 'Agroindustrias  Chrysef',
            'rol_name' => 'Admin',
            'user_plan_id' => 2,
        ]);

        $user->assignRole('Administrador');


        $user = User::create([
            'name' => $faker->firstName,
            'paterno' => $faker->lastName,
            'materno' => $faker->lastName,
            'dni' => $faker->numberBetween(10000000, 99999999),
            'email' => 'encargado@gmail.com',
            'password' => 'password',
            'user_plan_nombre' => 'Agroindustrias  Chrysef',
            'rol_name' => 'Encargado',
            'user_plan_id' => 2,
        ]);

        $user->assignRole('Encargado');
    }
}
