<template>
    <AdminLayout>
        <HeadingPage title="Planta" subtitle="Información de la Planta">
        </HeadingPage>
        <v-container fluid class="pt-0">
            <v-toolbar theme="dark">
                <v-toolbar-title>
                    {{ planta.plan_razon_social }}
                </v-toolbar-title>

                <v-spacer></v-spacer>

                <template v-slot:extension>
                    <v-tabs v-model="tab">
                        <v-tab value="general">General</v-tab>
                        <v-tab value="trabajadores">Trabajadores</v-tab>
                        <!-- <v-tab value="maquinaria">Maquinaria</v-tab> -->
                        <!-- <v-tab value="movilidades">Movilidades</v-tab> -->
                        <v-tab value="productos">Productos</v-tab>
                        <v-tab value="insumos">Insumos</v-tab>
                    </v-tabs>
                </template>
            </v-toolbar>

            <v-window v-model="tab">
                <v-window-item value="general">
                    <v-card>
                        <MapLeaflet></MapLeaflet>

                        <v-row class="pb-4">
                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Razón Social:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong>${planta.plan_razon_social}</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle v-text="'RUC:'" />
                                    <v-list-item-title
                                        v-html="
                                            `<strong>${planta.plan_ruc}</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle v-text="'Marca:'" />
                                    <v-list-item-title
                                        v-html="
                                            `<strong>${planta.plan_marca}</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Tipo de Planta:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong>Tipo - ${planta.plan_tipo_planta}</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle v-text="'Ubigeo:'" />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${
                                                planta.ubig_completo || 'N/A'
                                            }</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle v-text="'Sector:'" />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${
                                                planta.plan_sector || 'N/A'
                                            }</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Comunidad:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${
                                                planta.plan_barrio_comunidad ||
                                                'N/A'
                                            }</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Ubicación:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${
                                                planta.plan_latitud +
                                                ' ' +
                                                planta.plan_longitud
                                            }</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Registro Sanitario:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${planta.plan_registro_sanitario}</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Marca Registrada:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${
                                                planta.plan_marca_registrada
                                                    ? 'Sí'
                                                    : 'No'
                                            }</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Tecnificación:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${
                                                planta.plan_tecnificacion
                                                    ? 'Sí'
                                                    : 'No'
                                            }</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Tecnificación:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${
                                                planta.plan_tecnificacion
                                                    ? 'Sí'
                                                    : 'No'
                                            }</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Parámetros DIGESA:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${
                                                planta.plan_parametros_digesa
                                                    ? 'Sí'
                                                    : 'No'
                                            }</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Parámetros de Producción:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${
                                                planta.plan_parametros_produccion
                                                    ? 'Sí'
                                                    : 'No'
                                            }</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Capacitación TDD:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${
                                                planta.plan_capacitacion_tdd
                                                    ? 'Sí'
                                                    : 'No'
                                            }</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Tipo Compañía:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${planta.tipo_compania.tcomp_nombre}</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Nivel Capacitación:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${planta.nivel_capacitacion.ncap_nombre}</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Calidad Producto:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${planta.calidad_producto.cpro_nombre}</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-list-item>
                                    <v-list-item-subtitle
                                        v-text="'Institución:'"
                                    />
                                    <v-list-item-title
                                        v-html="
                                            `<strong> ${planta.institucion.inst_nombre}</strong>`
                                        "
                                    />
                                </v-list-item>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-window-item>
                <v-window-item value="trabajadores">
                    <v-card>
                        <v-list-item
                            class="py-3"
                            v-for="(item, index) in empleados"
                            :key="index"
                        >
                            <v-list-item-title>
                                {{
                                    `${item.empleado.empl_nombres}  ${item.empleado.empl_paterno}  ${item.empleado.empl_materno} | ${item.empleado.empl_dni}`
                                }}
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                {{
                                    `${item.empleado.empl_telefono}  | ${item.empleado.empl_email} |  Sexo: ${item.empleado.empl_sexo}`
                                }}
                            </v-list-item-subtitle>
                        </v-list-item>
                    </v-card>
                </v-window-item>
                <v-window-item value="maquinaria">
                    <v-card>
                        <v-card-item>
                            <v-list-item> </v-list-item>
                        </v-card-item>
                    </v-card>
                </v-window-item>
                <v-window-item value="movilidades"> movilidades </v-window-item>
                <v-window-item value="productos">
                    <v-card>
                        <v-list-item
                            class="py-3"
                            v-for="(item, index) in productos"
                            :key="index"
                        >
                            <v-list-item-title>
                                {{ `${item.prod_nombre}` }}
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                {{
                                    ` Stock: ${item.prod_stock} | Tipo: ${item.tpro_nombre} `
                                }}
                            </v-list-item-subtitle>
                        </v-list-item>
                    </v-card>

                </v-window-item>
                <v-window-item value="insumos">

                  <v-card>
                        <v-list-item
                            class="py-3"
                            v-for="(item, index) in insumos"
                            :key="index"
                        >
                            <v-list-item-title>
                                {{ `${item.insu_nombre}` }}
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                {{
                                    ` Stock: ${item.insu_stock} | UM: ${item.umed_nombre} `
                                }}
                            </v-list-item-subtitle>
                        </v-list-item>
                    </v-card>
                </v-window-item>
            </v-window>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import { router } from "@inertiajs/vue3";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import BtnDialog from "@/components/BtnDialog.vue";
import Formulario from "./components/Formulario.vue";
import MapLeaflet from "../../components/MapLeaflet.vue";
import { ref } from "vue";

const props = defineProps({
    planta: Object,
    empleados: Array,
    productos: Array,
    insumos: Array,
});

const tab = ref("general");

const url = "/config/plantas";
const primaryKey = "plan_id";
</script>
