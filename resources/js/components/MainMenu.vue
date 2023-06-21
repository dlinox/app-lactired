<template>
    <v-list v-model:opened="menuOpen" nav density="compact">
        <v-list-subheader>Menu</v-list-subheader>

        <template v-for="(menu, index) in menuMain" :key="index">
            <template v-if="menu.group == null">
                <v-list-item
                    :prepend-icon="menu.icon"
                    :title="menu.title"
                    color="primary"
                    :class="
                        router.page.url == menu.to
                            ? 'v-list-item--active text-primary'
                            : ''
                    "
                    @click="router.get(menu.to)"
                />
            </template>
            <template v-else>
                <v-list-group :value="menu.value">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            :prepend-icon="menu.icon"
                            :title="menu.title"
                            color="primary"
                        ></v-list-item>
                    </template>
                    <template v-for="submenu in menu.group">
                        <template v-if="submenu.group == null">
                            <v-list-item
                                :title="submenu.title"
                                color="primary"
                                :class="
                                    router.page.url == submenu.to
                                        ? 'v-list-item--active text-primary'
                                        : ''
                                "
                                @click="router.get(submenu.to)"
                            >
                                <template #prepend>
                                    <v-icon class="ms-0 me-2" size="x-large"
                                        >mdi-circle-small
                                    </v-icon>
                                </template>
                            </v-list-item>
                        </template>
                        <template v-else>
                            <v-list-group :value="submenu.value">
                                <template v-slot:activator="{ props }">
                                    <v-list-item
                                        v-bind="props"
                                        :title="submenu.title"
                                        color="primary"
                                    >
                                        <template #prepend>
                                            <v-icon class="mr-2" size="x-large"
                                                >mdi-circle-small
                                            </v-icon>
                                        </template>
                                    </v-list-item>
                                </template>

                                <v-list-item
                                    v-for="(subsubmenu, k) in submenu.group"
                                    :key="k"
                                    :title="subsubmenu.title"
                                    :value="subsubmenu.value"
                                    color="primary"
                                    @click="goToPage(subsubmenu.to)"
                                    :class="
                                        subsubmenu.to == router.page.url
                                            ? 'v-list-item--active text-primary'
                                            : ''
                                    "
                                >
                                    <template #prepend>
                                        <v-icon class="ms-3 me-2" size="x-large"
                                            >mdi-circle-small
                                        </v-icon>
                                    </template>
                                </v-list-item>
                            </v-list-group>
                        </template>
                    </template>
                </v-list-group>
            </template>
        </template>
    </v-list>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const menuAcopio = [
    {
        title: "Acopio",
        value: "acopio",
        icon: null,
        to: "/acopio/create",
        group: null,
    },
    // {
    //     title: "Consultar acopio",
    //     value: "acopio.consultar",
    //     icon: null,
    //     to: "/acopio/consultar",
    //     group: null,
    // },
];

const menuCompras = [
    {
        title: "Compras",
        value: "compras",
        icon: null,
        to: "/compras/registrar-compra",
        group: null,
    },
    {
        title: "Proveedores",
        value: "/compras/proveedores",
        icon: null,
        to: "/compras/proveedores",
        group: null,
    },
];

const menuVentas = [
    {
        title: "Ventas",
        value: "ventas",
        icon: null,
        to: "/ventas/registrar-venta",
        group: null,
    },
    {
        title: "Clientes",
        value: "ventas/clientes",
        icon: null,
        to: "/ventas/clientes",
        group: null,
    },
];

const menuAlmacen = [
    {
        title: "Productos",
        value: "productos",
        icon: null,
        to: "/almacen/productos",
        group: null,
    },
    {
        title: "Insumos",
        value: "insumos",
        icon: null,
        to: "/almacen/insumos",
        group: null,
    },
];

const menuConfiguracionEmpresa = [
    {
        title: "Instituciones",
        value: "instituciones",
        icon: null,
        to: "/config/empresa/instituciones",
        group: null,
    },

    {
        title: "Mercados",
        value: "mercados",
        icon: null,
        to: "/config/empresa/mercados",
        group: null,
    },

    {
        title: "Nivel Capacitación",
        value: "nivel-capacitaciones",
        icon: null,
        to: "/config/empresa/nivel-capacitaciones",
        group: null,
    },
    {
        title: "Calidad Producto",
        value: "calidad-productos",
        icon: null,
        to: "/config/empresa/calidad-productos",
        group: null,
    },
    {
        title: "T. Empresa",
        value: "tipo-empresas",
        icon: null,
        to: "/config/empresa/tipo-empresas",
        group: null,
    },
    {
        title: "T. Comñania",
        value: "tipo-companias",
        icon: null,
        to: "/config/empresa/tipo-companias",
        group: null,
    },

    {
        title: "T. Especializaciones",
        value: "especializaciones",
        icon: null,
        to: "/config/empresa/tipo-especializaciones",
        group: null,
    },

    {
        title: "T. Certificaciones",
        value: "tipo-certificaciones",
        icon: null,
        to: "/config/empresa/tipo-certificaciones",
        group: null,
    },
    {
        title: "T. Transporte",
        value: "mercados",
        icon: null,
        to: "/config/empresa/tipo-transportes",
        group: null,
    },
    {
        title: "T. Movilidad",
        value: "mercados",
        icon: null,
        to: "/config/empresa/tipo-movilidades",
        group: null,
    },

    {
        title: "T. Maquinarias",
        value: "mercados",
        icon: null,
        to: "/config/empresa/tipo-maquinarias",
        group: null,
    },
    {
        title: "T. Financiamiento",
        value: "mercados",
        icon: null,
        to: "/config/empresa/tipo-financiamientos",
        group: null,
    },
    {
        title: "T. Comprobantes",
        value: "mercados",
        icon: null,
        to: "/config/empresa/tipo-comprobantes",
        group: null,
    },
    {
        title: "Origen Aguas",
        value: "mercados",
        icon: null,
        to: "/config/empresa/origen-aguas",
        group: null,
    },
];

const menuConfiguracionAlmacen = [
    {
        title: "T. Productos",
        value: "tproductos",
        icon: null,
        to: "/config/almacen/tipo-productos",
        group: null,
    },
    {
        title: "Unidad de Medidas",
        value: "unidades",
        icon: null,
        to: "/config/almacen/unidades-medida",
        group: null,
    },
];

const menuConfiguracionTrabajador = [
    {
        title: "Cargos",
        value: "cargos",
        icon: null,
        to: "/config/trabajador/cargos",
        group: null,
    },
    {
        title: "Tipos de documento",
        value: "documentos",
        icon: null,
        to: "/config/trabajador/tipo-documentos",
        group: null,
    },
];


const menuConfiguracion = [
    {
        title: "Plantas",
        value: "plantas",
        icon: "mdi-circle-small",
        to: "/config/plantas",
        group: null,
    },
    {
        title: "Usuarios",
        value: "usuarios",
        icon: "mdi-circle-small",
        to: "/config/usuarios",
        group: null,
    },
    {
        title: "Empresa",
        value: "empresa",
        icon: "mdi-circle-small",
        to: "/empresa",
        group: menuConfiguracionEmpresa,
    },

    {
        title: "Almacen",
        value: "configuracion.almacen",
        icon: "mdi-circle-small",
        to: "/almacen",
        group: menuConfiguracionAlmacen,
    },

    {
        title: "Trabajador",
        value: "configuracion.trabajador",
        icon: "mdi-circle-small",
        to: "/trabajador",
        group: menuConfiguracionTrabajador,
    },
];

const menuMain = [
    {
        title: "Dashboard",
        value: "dashboard",
        icon: "mdi-home",
        to: "/",
        group: null,
    },

    {
        title: "Acopio de Leche",
        value: "acopio.leche",
        icon: "mdi-basket-fill",
        to: "#",
        group: menuAcopio,
    },

    {
        title: "Compras",
        value: "compras",
        icon: "mdi-cart-check",
        to: "#",
        group: menuCompras,
    },

    {
        title: "Ventas",
        value: "ventas",
        icon: "mdi-cash-register",
        to: "#",
        group: menuVentas,
    },

    {
        title: "Almacen",
        value: "almacen",
        icon: "mdi-archive", //mdi-greenhouse
        to: "#",
        group: menuAlmacen,
    },
    {
        title: "Configuracion",
        value: "configuracion",
        icon: "mdi-archive", //mdi-greenhouse
        to: "#",
        group: menuConfiguracion,
    },
];

//const currentMenu = computed(() => router.page.url.split('/')[1] );
const goToPage = (to) => {
    router.get(to);
};

const menuOpen = ref([router.page.url.split("/")[1]]);
</script>

<style scoped>
.v-list-group__items .v-list-item {
    padding-inline-start: 25px !important;
}
</style>
