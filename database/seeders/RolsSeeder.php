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


        $admin = Role::create(['name' => 'Administrador']);
        $encargado = Role::create(['name' => 'Encargado']);

        //*Permiso en el dashboard
        Permission::create(['group' => 'dashboard', 'name' => 'dashboard']);
        Permission::create(['group' => 'dashboard', 'name' => 'pagos-pendientes']);
        Permission::create(['group' => 'dashboard', 'name' => 'ultimas-compras']);
        Permission::create(['group' => 'dashboard', 'name' => 'reporte-de-ingresos']);

        //*Permisos de acopio
        Permission::create(['group' => 'acopio', 'name' => 'menu-de-acopio']);
        Permission::create(['group' => 'acopio', 'name' => 'ver-acopios']);
        Permission::create(['group' => 'acopio', 'name' => 'registrar-acopio']);
        Permission::create(['group' => 'acopio', 'name' => 'editar-acopio']);
        Permission::create(['group' => 'acopio', 'name' => 'anular-acopio']);

        // **Permisos de acopio pagos
        Permission::create(['group' => 'acopio', 'name' => 'realizar-pago-de-acopio']);
        Permission::create(['group' => 'acopio', 'name' => 'ver-pagos-de-acopio']);
        Permission::create(['group' => 'acopio', 'name' => 'aunlar-pagos-de-acopio']);

        // *Permisos de acopio compras
        Permission::create(['group' => 'compras', 'name' => 'menu-de-compras']);
        //TODO: crear los permisos nesesarios

        // *Permisos de acopio ventas
        Permission::create(['group' => 'ventas', 'name' => 'menu-de-ventas']);
        //TODO: crear los permisos

        // *Permisos de acopio almacen
        Permission::create(['group' => 'almacen', 'name' => 'menu-de-almacen']);
        //TODO: crear los permisos nesesarios

        // *Permisos de acopio configuracion
        Permission::create(['group' => 'configuracion', 'name' => 'menu-de-configuracion']);
        //TODO: crear los permisos nesesarios

        $admin->syncPermissions(
            [
                'dashboard',
                'menu-de-configuracion',
                'menu-de-almacen',
                'menu-de-compras',
                'menu-de-ventas',
                'menu-de-acopio'
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
