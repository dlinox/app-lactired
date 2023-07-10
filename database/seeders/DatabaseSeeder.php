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
        for ($i = 1; $i < 6; $i++) {
            Institucion::create([
                'inst_nombre' => "INSTITUCION $i",
                'inst_naturaleza' => "PRIVADO",
                'inst_nivel' => "REGIONAL",

            ]);

            Mercado::create([
                'merc_nombre' => "MERCADO $i",
            ]);


            NivelCapacitacion::create([
                'ncap_nombre' => "NIVEL CAPACITACION $i",
            ]);


            CalidadProducto::create([
                'cpro_nombre' => "CALIDAD PRODUCTO $i",
            ]);

            TipoCompania::create([
                'tcomp_nombre' => "TIPO COMPANIA $i",
            ]);

            TipoEspecializacion::create([
                'tesp_nombre' => "TIPO Especializacion $i",
            ]);

            TipoCertificacion::create([
                'tcer_nombre' => "TIPO Certificacion $i",
            ]);

            TipoTransporte::create([
                'ttra_nombre' => "TIPO Transporte $i",
            ]);

            TipoMovilidad::create([
                'tmov_nombre' => "TIPO MOVLIDAD $i",
            ]);

            TipoMaquinaria::create([
                'tmaq_nombre' => "TIPO MAQUINARIA $i",
            ]);

            TipoFinanciamiento::create([
                'tfin_nombre' => "TIPO Financiamiento $i",
            ]);

            OrigenAgua::create([
                'oagu_nombre' => "ORIGEN AGUA $i",
            ]);

            TipoComprobante::create([
                'tcom_nombre' => "TIPO COMBROVANTE $i",
            ]);
        }

        $this->call(PlantasSeeder::class);


        //ALMACEN
        for ($i = 1; $i < 6; $i++) {
            TipoProducto::create([
                'tpro_nombre' => "TIPO PRODUCTO $i",
            ]);
        }

        UnidadMedida::create([
            'umed_nombre' => 'Litros',
            'umed_simbolo' => 'L',
        ]);

        UnidadMedida::create([
            'umed_nombre' => 'Unidad',
            'umed_simbolo' => 'U',
        ]);

        UnidadMedida::create([
            'umed_nombre' => 'Kilogramo',
            'umed_simbolo' => 'kg',
        ]);


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

        foreach (Planta::all() as $value) {


            Producto::create([
                'prod_nombre' => 'Producto 1 P' . $value->plan_id,
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 1,
                'prod_tpro_id' => 3,
                'prod_plan_id' => $value->plan_id,
            ]);

            Producto::create([
                'prod_nombre' => 'Producto 2 P' . $value->plan_id,
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 2,
                'prod_tpro_id' => 1,
                'prod_plan_id' => $value->plan_id,
            ]);

            Producto::create([
                'prod_nombre' => 'Producto 3 P' . $value->plan_id,
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 1,
                'prod_tpro_id' => 2,
                'prod_plan_id' => $value->plan_id,
            ]);
            

            Insumo::create([
                'insu_nombre' => 'LECHE P' . $value->plan_id,
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_leche' => 1,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);

            Insumo::create([
                'insu_nombre' => 'Insumo 1 P' . $value->plan_id,
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);

            Insumo::create([
                'insu_nombre' => 'Insumo 2 P' . $value->plan_id,
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);
        }



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

        //ACOPIO
        for ($i = 1; $i < 6; $i++) {
            Posicion::create(['posi_nombre' => "Posicion $i"]);
            GradoInstruccion::create(['gins_nombre' => "Grado de instruccion $i"]);
            Profesion::create(['prof_nombre' => "¨Profecion $i"]);
            RolDesempenio::create(['rdes_nombre' => "Rol desempeñado $i"]);
        }

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
                'empl_posi_id' => $faker->numberBetween(1, 5),
                'empl_gins_id' => $faker->numberBetween(1, 5),
                'empl_prof_id' => $faker->numberBetween(1, 5),
                'empl_rdes_id' => $faker->numberBetween(1, 5),
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
