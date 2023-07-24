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
            "icon" => "mdi-home",
            "to" => "/",
            'can' => 'dashboard',
        ],
        [
            "title" => "Acopio de Leche",
            "icon" => "mdi-basket-fill",
            "to" => "/acopio",
            'can' => 'menu-de-acopio',
            "group" => [
                [
                    "title" => "Acopio",
                    "to" => "/acopio/create",
                ],
                [
                    "title" => "Pagos",
                    "to" => "/acopio/pagos",
                ],
                [
                    "title" => "Consultar acopio",
                    "to" => "/acopio",
                ]
            ]
        ],
        [
            "title" => "Compras",
            "icon" => "mdi-cart-check",
            "to" => "/compras",
            'can' => 'menu-de-compras',
            "group" => [
                [
                    "title" => "Compras",
                    "to" => "/compras",
                ],
                [
                    "title" => "Proveedores",
                    "to" => "/compras/proveedores",
                ]
            ]
        ],
        [
            "title" => "Ventas",
            "icon" => "mdi-cash-register",
            'can' => 'menu-de-ventas',
            "to" => "/ventas",
            "group" => [
                [
                    "title" => "Ventas",

                    "to" => "/ventas",
                ],
                [
                    "title" => "Clientes",
                    "to" => "/ventas/clientes",
                ]
            ]
        ],
        [
            "title" => "Almacen",
            "icon" => "mdi-archive",
            "to" => "/almacen",
            'can' => 'menu-de-almacen',
            "group" => [
                [
                    "title" => "Productos",
                    "to" => "/almacen/productos",
                ],
                [
                    "title" => "Insumos",
                    "to" => "/almacen/insumos",
                ]
            ]
        ],
        [
            "title" => "Plantas",
            "icon" => "mdi-domain",
            "to" => "/plantas",
            'can' => 'menu-de-planta',
            "group" => [
                [
                    "title" => "Plantas",
                    "to" => "/plantas",
                ],
                [
                    "title" => "Trabajadores",
                    "to" => "/plantas/empleados",
                ]
            ]
        ],
        [
            "title" => "Configuracion",
            "icon" => "mdi-cog",
            'can' => 'menu-de-configuracion',
            "to" => "/config",
            "group" => [
                [
                    "title" => "Empresa",
                    "icon" => "mdi-circle-small",
                    "to" => "/config/empresa",
                    "group" => [
                        [
                            "title" => "Instituciones",
                            "to" => "/config/empresa/instituciones",
                        ],
                        [
                            "title" => "Mercados",
                            "to" => "/config/empresa/mercados",
                        ],
                        [
                            "title" => "Nivel Capacitación",
                            "to" => "/config/empresa/nivel-capacitaciones",
                        ],
                        [
                            "title" => "Calidad Producto",
                            "to" => "/config/empresa/calidad-productos",
                        ],
                        [
                            "title" => "T. Empresa",
                            "to" => "/config/empresa/tipo-empresas",
                        ],
                        [
                            "title" => "T. Comñania",
                            "to" => "/config/empresa/tipo-companias",
                        ],
                        [
                            "title" => "T. Especializaciones",
                            "to" => "/config/empresa/tipo-especializaciones",
                        ],
                        [
                            "title" => "T. Certificaciones",
                            "to" => "/config/empresa/tipo-certificaciones",
                        ],
                        [
                            "title" => "T. Transporte",
                            "to" => "/config/empresa/tipo-transportes",
                        ],
                        [
                            "title" => "T. Movilidad",
                            "to" => "/config/empresa/tipo-movilidades",
                        ],
                        [
                            "title" => "T. Maquinarias",
                            "to" => "/config/empresa/tipo-maquinarias",
                        ],
                        [
                            "title" => "T. Financiamiento",
                            "to" => "/config/empresa/tipo-financiamientos",
                        ],
                        [
                            "title" => "T. Comprobantes",
                            "to" => "/config/empresa/tipo-comprobantes",
                        ],
                        [
                            "title" => "Origen Aguas",
                            "to" => "/config/empresa/origen-aguas",
                        ]
                    ],
                ],
                [
                    "title" => "Almacen",
                    "icon" => "mdi-circle-small",
                    "to" => "/config/almacen",
                    "group" => [
                        [
                            "title" => "T. Productos",
                            "to" => "/config/almacen/tipo-productos",
                        ],
                        [
                            "title" => "Unidad de Medidas",
                            "to" => "/config/almacen/unidades-medida",
                        ]
                    ]
                ],
                [
                    "title" => "Trabajador",
                    "icon" => "mdi-circle-small",
                    "to" => "/config/trabajador",
                    "group" => [
                        [
                            "title" => "Cargos",
                            "to" => "/config/trabajador/cargos",
                        ],

                        [
                            "title" => "Grados de instrucción",
                            "to" => "/config/trabajador/grado-instruccion",
                        ],

                        [
                            "title" => "Profesiones",
                            "to" => "/config/trabajador/profeciones",
                        ],
                    ]
                ]
            ]
        ],
        [
            "title" => "Seguridad",
            "icon" => "mdi-shield-half-full",
            "to" => "/seguridad",
            'can' => 'menu-de-seguridad',
            "group" => [
                [
                    "title" => "Usuarios",
                    "to" => "/seguridad/usuarios",
                ],
                [
                    "title" => "Roles",
                    "to" => "/seguridad/roles",
                ],
                // [
                //     "title" => "Copias de suguridad",
                //     "to" => "/seguridad/backups",
                // ],
            ]
        ],
    ];
}
