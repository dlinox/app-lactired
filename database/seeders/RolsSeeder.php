<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolsSeeder extends Seeder
{

    public function run(): void
    {


        $admin = Role::create(['name' => 'Administrador', 'route_redirect' => '/']);
        $encargado = Role::create(['name' => 'Encargado', 'route_redirect' => '/']);

        //*Permiso en el dashboard
        Permission::create(['group_name' => 'dashboard', 'name' => 'dashboard']);
        Permission::create(['group_name' => 'dashboard', 'name' => 'pagos-pendientes']);
        Permission::create(['group_name' => 'dashboard', 'name' => 'ultimas-compras']);
        Permission::create(['group_name' => 'dashboard', 'name' => 'reporte-de-ingresos']);

        //*Permisos de acopio
        Permission::create(['group_name' => 'acopio', 'name' => 'menu-de-acopio']);
        Permission::create(['group_name' => 'acopio', 'name' => 'ver-acopios']);
        Permission::create(['group_name' => 'acopio', 'name' => 'registrar-acopio']);
        Permission::create(['group_name' => 'acopio', 'name' => 'editar-acopio']);
        Permission::create(['group_name' => 'acopio', 'name' => 'anular-acopio']);

        // **Permisos de acopio pagos
        Permission::create(['group_name' => 'acopio', 'name' => 'realizar-pago-de-acopio']);
        Permission::create(['group_name' => 'acopio', 'name' => 'ver-pagos-de-acopio']);
        Permission::create(['group_name' => 'acopio', 'name' => 'aunlar-pagos-de-acopio']);

        // *Permisos de acopio compras
        Permission::create(['group_name' => 'compras', 'name' => 'menu-de-compras']);
        //TODO: crear los permisos nesesarios

        // *Permisos de acopio ventas
        Permission::create(['group_name' => 'ventas', 'name' => 'menu-de-ventas']);
        //TODO: crear los permisos

        // *Permisos de acopio almacen
        Permission::create(['group_name' => 'almacen', 'name' => 'menu-de-almacen']);
        //TODO: crear los permisos nesesarios

        // *Permisos de finanzas
        Permission::create(['group_name' => 'finanzas', 'name' => 'menu-de-finanzas']);

        // *Permisos de planta
        Permission::create(['group_name' => 'plantas', 'name' => 'menu-de-planta']);
        //TODO: crear los permisos nesesarios

        // *Permisos de meunu empleados
        Permission::create(['group_name' => 'empleados', 'name' => 'menu-de-empleados']);
        //TODO: crear los permisos nesesarios

        // *Permisos de acopio configuracion
        Permission::create(['group_name' => 'configuracion', 'name' => 'menu-de-configuracion']);
        //TODO: crear los permisos nesesarios

        // *Permisos de seguridad
        Permission::create(['group_name' => 'seguridad', 'name' => 'menu-de-seguridad']);
        //TODO: crear los permisos nesesarios

        $admin->syncPermissions(
            [
                'dashboard',
                'menu-de-acopio',
                'menu-de-configuracion',
                'menu-de-almacen',
                'menu-de-compras',
                'menu-de-ventas',
                'menu-de-planta',
                'menu-de-finanzas',
                'menu-de-seguridad',
                'menu-de-empleados'
            ]
        );

        $encargado->syncPermissions(
            [
                'dashboard',
                'menu-de-acopio',
                'menu-de-compras',
                'menu-de-ventas',
                'menu-de-almacen',
            ]
        );
    }
}
