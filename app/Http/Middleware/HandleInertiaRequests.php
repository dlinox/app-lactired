<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{

    protected $rootView = 'app';
    protected $permisos = [];

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => function () use ($request) {
                return [
                    'user' => $request->user() ? [
                        'id' => $request->user()->id,
                        'email' => $request->user()->email,
                        'name' => $request->user()->name . ' ' .  $request->user()->paterno . ' ' .  $request->user()->materno,
                        'photo' =>  $request->user()->profile_photo_path,
                        'user_plan_id' =>  $request->user()->ofic_id,
                        'rol_name' =>  $request->user()->rol_name,
                        'user_plan_nombre' =>  $request->user()->user_plan_nombre,
                        'menu' => Auth::check() ?  $this->getUserMenu($request->user()) : null
                    ] : null,
                ];
            },

            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'success' => fn () => $request->session()->get('success'),
                'data' => fn () => $request->session()->get('data'),
            ],
        ]);
    }

    private function getUserMenu($user)
    {

        if ($user->hasRole('Super Admin')) {
            return $this->menus;
        }

        $user->getAllPermissions()->map(function ($permiso) {
            array_push($this->permisos, $permiso->name);
        });


        $menu = [];

        foreach ($this->menus as $item) {

            $can  =  explode(",", $item['can']);
            if (array_intersect($can,  $this->permisos)) {
                array_push($menu,  $item);
            }
        }

        return $menu;
    }

    private $menus = [
        [
            "title" => "Dashboard",
            "value" => "dashboard",
            "icon" => "mdi-home",
            "to" => "/",
            'can' => 'dashboard',
            "group" => null
        ],
        [
            "title" => "Acopio de Leche",
            "value" => "acopio.leche",
            "icon" => "mdi-basket-fill",
            "to" => "#",
            'can' => 'menu-de-acopio',
            "group" => [
                [
                    "title" => "Acopio",
                    "value" => "acopio",
                    "icon" => null,
                    "to" => "/acopio/create",
                    "group" => null
                ],
                [
                    "title" => "Pagos",
                    "value" => "acopio.pasgos",
                    "icon" => null,
                    "to" => "/acopio/pagos/create",
                    "group" => null
                ],
                [
                    "title" => "Consultar acopio",
                    "value" => "acopio.consultas",
                    "icon" => null,
                    "to" => "/acopio/consltas",
                    "group" => null
                ]
            ]
        ],
        [
            "title" => "Compras",
            "value" => "compras",
            "icon" => "mdi-cart-check",
            "to" => "#",
            'can' => 'menu-de-compras',
            "group" => [
                [
                    "title" => "Compras",
                    "value" => "compras",
                    "icon" => null,
                    "to" => "/compras/registrar-compra",
                    "group" => null
                ],
                [
                    "title" => "Proveedores",
                    "value" => "/compras/proveedores",
                    "icon" => null,
                    "to" => "/compras/proveedores",
                    "group" => null
                ]
            ]
        ],
        [
            "title" => "Ventas",
            "value" => "ventas",
            "icon" => "mdi-cash-register",
            'can' => 'menu-de-ventas',
            "to" => "#",
            "group" => [
                [
                    "title" => "Ventas",
                    "value" => "ventas",
                    "icon" => null,
                    "to" => "/ventas/registrar-venta",
                    "group" => null
                ],
                [
                    "title" => "Clientes",
                    "value" => "ventas/clientes",
                    "icon" => null,
                    "to" => "/ventas/clientes",
                    "group" => null
                ]
            ]
        ],
        [
            "title" => "Almacen",
            "value" => "almacen",
            "icon" => "mdi-archive",
            "to" => "#",
            'can' => 'menu-de-almacen',
            "group" => [
                [
                    "title" => "Productos",
                    "value" => "productos",
                    "icon" => null,
                    "to" => "/almacen/productos",
                    "group" => null
                ],
                [
                    "title" => "Insumos",
                    "value" => "insumos",
                    "icon" => null,
                    "to" => "/almacen/insumos",
                    "group" => null
                ]
            ]
        ],
        [
            "title" => "Configuracion",
            "value" => "configuracion",
            "icon" => "mdi-archive",
            'can' => 'menu-de-configuracion',
            "to" => "#",
            "group" => [
                [
                    "title" => "Plantas",
                    "value" => "plantas",
                    "icon" => "mdi-circle-small",
                    "to" => "/config/plantas",
                    "group" => null
                ],
                [
                    "title" => "Usuarios",
                    "value" => "usuarios",
                    "icon" => "mdi-circle-small",
                    "to" => "/config/usuarios",
                    "group" => null
                ],
                [
                    "title" => "Empresa",
                    "value" => "empresa",
                    "icon" => "mdi-circle-small",
                    "to" => "/empresa",
                    "group" => [
                        [
                            "title" => "Instituciones",
                            "value" => "instituciones",
                            "icon" => null,
                            "to" => "/config/empresa/instituciones",
                            "group" => null
                        ],
                        [
                            "title" => "Mercados",
                            "value" => "mercados",
                            "icon" => null,
                            "to" => "/config/empresa/mercados",
                            "group" => null
                        ],
                        [
                            "title" => "Nivel Capacitación",
                            "value" => "nivel-capacitaciones",
                            "icon" => null,
                            "to" => "/config/empresa/nivel-capacitaciones",
                            "group" => null
                        ],
                        [
                            "title" => "Calidad Producto",
                            "value" => "calidad-productos",
                            "icon" => null,
                            "to" => "/config/empresa/calidad-productos",
                            "group" => null
                        ],
                        [
                            "title" => "T. Empresa",
                            "value" => "tipo-empresas",
                            "icon" => null,
                            "to" => "/config/empresa/tipo-empresas",
                            "group" => null
                        ],
                        [
                            "title" => "T. Comñania",
                            "value" => "tipo-companias",
                            "icon" => null,
                            "to" => "/config/empresa/tipo-companias",
                            "group" => null
                        ],
                        [
                            "title" => "T. Especializaciones",
                            "value" => "especializaciones",
                            "icon" => null,
                            "to" => "/config/empresa/tipo-especializaciones",
                            "group" => null
                        ],
                        [
                            "title" => "T. Certificaciones",
                            "value" => "tipo-certificaciones",
                            "icon" => null,
                            "to" => "/config/empresa/tipo-certificaciones",
                            "group" => null
                        ],
                        [
                            "title" => "T. Transporte",
                            "value" => "mercados",
                            "icon" => null,
                            "to" => "/config/empresa/tipo-transportes",
                            "group" => null
                        ],
                        [
                            "title" => "T. Movilidad",
                            "value" => "mercados",
                            "icon" => null,
                            "to" => "/config/empresa/tipo-movilidades",
                            "group" => null
                        ],
                        [
                            "title" => "T. Maquinarias",
                            "value" => "mercados",
                            "icon" => null,
                            "to" => "/config/empresa/tipo-maquinarias",
                            "group" => null
                        ],
                        [
                            "title" => "T. Financiamiento",
                            "value" => "mercados",
                            "icon" => null,
                            "to" => "/config/empresa/tipo-financiamientos",
                            "group" => null
                        ],
                        [
                            "title" => "T. Comprobantes",
                            "value" => "mercados",
                            "icon" => null,
                            "to" => "/config/empresa/tipo-comprobantes",
                            "group" => null
                        ],
                        [
                            "title" => "Origen Aguas",
                            "value" => "mercados",
                            "icon" => null,
                            "to" => "/config/empresa/origen-aguas",
                            "group" => null
                        ]



                    ],
                ],

                [
                    "title" => "Almacen",
                    "value" => "configuracion.almacen",
                    "icon" => "mdi-circle-small",
                    "to" => "/almacen",
                    "group" => [
                        [
                            "title" => "T. Productos",
                            "value" => "tproductos",
                            "icon" => null,
                            "to" => "/config/almacen/tipo-productos",
                            "group" => null
                        ],
                        [
                            "title" => "Unidad de Medidas",
                            "value" => "unidades",
                            "icon" => null,
                            "to" => "/config/almacen/unidades-medida",
                            "group" => null
                        ]
                    ]
                ],
                [
                    "title" => "Trabajador",
                    "value" => "configuracion.trabajador",
                    "icon" => "mdi-circle-small",
                    "to" => "/trabajador",
                    "group" => [
                        [
                            "title" => "Cargos",
                            "value" => "cargos",
                            "icon" => null,
                            "to" => "/config/trabajador/cargos",
                            "group" => null
                        ],
                        [
                            "title" => "Tipos de documento",
                            "value" => "documentos",
                            "icon" => null,
                            "to" => "/config/trabajador/tipo-documentos",
                            "group" => null
                        ]
                    ]
                ]
            ]
        ]
    ];
}
