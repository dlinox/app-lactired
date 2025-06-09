<?php

namespace Database\Seeders;

use App\Models\Insumo;
use App\Models\Planta;
use App\Models\Producto;
use App\Models\TipoProducto;
use App\Models\UnidadMedida;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //******************* PRODUCTOS 
        TipoProducto::create([
            'tpro_nombre' => "Productos lácteos líquidos",
        ]);


        TipoProducto::create([
            'tpro_nombre' => "Productos lácteos concentrados",
        ]);

        TipoProducto::create([
            'tpro_nombre' => "Productos lácteos procesados",
        ]);


        UnidadMedida::create([
            'umed_nombre' => 'Litros',
            'umed_simbolo' => 'L',
        ]);

        UnidadMedida::create([
            'umed_nombre' => 'Galones',
            'umed_simbolo' => 'Gal',
        ]);

        UnidadMedida::create([
            'umed_nombre' => 'Latas',
            'umed_simbolo' => 'Latas',
        ]);

        UnidadMedida::create([
            'umed_nombre' => 'Bolsas',
            'umed_simbolo' => 'Bolsas',
        ]);

        UnidadMedida::create([
            'umed_nombre' => 'Barras',
            'umed_simbolo' => 'Barras',
        ]);


        UnidadMedida::create([
            'umed_nombre' => 'Envases',
            'umed_simbolo' => 'Envases',
        ]);



        foreach (Planta::all() as $value) {


            Producto::create([
                'prod_nombre' => 'Leche pasteurizada',
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 1,
                'prod_tpro_id' => 1,
                'prod_precio_venta' => 1.50,
                'prod_plan_id' => $value->plan_id,
            ]);

            Producto::create([
                'prod_nombre' => 'Leche homogeneizada',
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 1,
                'prod_tpro_id' => 1,
                'prod_precio_venta' => 1.75,
                'prod_plan_id' => $value->plan_id,
            ]);

            Producto::create([
                'prod_nombre' => 'Leche descremada o leche baja en grasa',
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 1,
                'prod_tpro_id' => 1,
                'prod_precio_venta' => 1.25,
                'prod_plan_id' => $value->plan_id,
            ]);

            Producto::create([
                'prod_nombre' => 'Leche condensada',
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 1,
                'prod_tpro_id' => 2,
                'prod_precio_venta' => 2.00,
                'prod_plan_id' => $value->plan_id,
            ]);


            Producto::create([
                'prod_nombre' => 'Leche en polvo',
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 1,
                'prod_tpro_id' => 2,
                'prod_precio_venta' => 2.50,
                'prod_plan_id' => $value->plan_id,
            ]);


            Producto::create([
                'prod_nombre' => 'Crema',
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 1,
                'prod_tpro_id' => 3,
                'prod_precio_venta' => 1.80,
                'prod_plan_id' => $value->plan_id,
            ]);


            Producto::create([
                'prod_nombre' => 'Mantequilla',
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 1,
                'prod_tpro_id' => 3,
                'prod_precio_venta' => 2.20,
                'prod_plan_id' => $value->plan_id,
            ]);


            Producto::create([
                'prod_nombre' => 'Queso',
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 1,
                'prod_tpro_id' => 3,
                'prod_precio_venta' => 3.00,
                'prod_plan_id' => $value->plan_id,
            ]);


            Producto::create([
                'prod_nombre' => 'Yogur',
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 1,
                'prod_tpro_id' => 3,
                'prod_precio_venta' => 1.60,
                'prod_plan_id' => $value->plan_id,
            ]);

            Producto::create([
                'prod_nombre' => 'Helado',
                'prod_stock' => 20,
                'prod_medida' => 15.00,
                'prod_umed_id' => 1,
                'prod_tpro_id' => 3,
                'prod_precio_venta' => 2.80,
                'prod_plan_id' => $value->plan_id,
            ]);



            Insumo::create([
                'insu_nombre' => 'LECHE',
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_leche' => 1,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);

            Insumo::create([
                'insu_nombre' => 'Envases y empaques',
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);

            Insumo::create([
                'insu_nombre' => 'Etiquetas y materiales de identificación',
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);

            Insumo::create([
                'insu_nombre' => 'Aditivos y conservantes',
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);

            Insumo::create([
                'insu_nombre' => 'Fermentos lácticos',
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);

            Insumo::create([
                'insu_nombre' => 'Azúcar',
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);

            Insumo::create([
                'insu_nombre' => 'Grasas',
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);


            Insumo::create([
                'insu_nombre' => 'Cultivos lácticos',
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);


            Insumo::create([
                'insu_nombre' => 'Colorantes y saborizantes',
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);

            Insumo::create([
                'insu_nombre' => 'Envases para transporte',
                'insu_stock' => 20,
                'insu_medida' => 15.00,
                'insu_umed_id' => 1,
                'insu_plan_id' => $value->plan_id,
            ]);
           
        }
    }
}
