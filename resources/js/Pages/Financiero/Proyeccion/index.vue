<template>
    <AdminLayout>
        <HeadingPage title="Proyecciones" subtitle="Proyecciones financieras">
            <template #actions>
                <v-btn
                    size="large"
                    variant="flat"
                    color="primary"
                    @click="save"
                >
                    Guardar
                </v-btn>
            </template>
        </HeadingPage>
        <v-container fluid class="pt-0">
            <v-card>
                <v-card color="primary" variant="tonal" class="">
                    <v-card-item class="">
                        <v-row justify="space-between" align="center">
                            <v-col cols="8">
                                <h4 class="text-h6 text-black">
                                    Proyecciones de ventas del año
                                    <strong>{{ year }}</strong>
                                </h4>
                            </v-col>
                            <v-col cols="2">
                                <v-select
                                    v-model="year"
                                    :items="yearOptions"
                                    label="Año"
                                    density="compact"
                                    class="mt-2 text-black"
                                    :clearable="false"
                                    @update:model-value="
                                        router.get(url + `?anio=${year}`)
                                    "
                                />
                            </v-col>
                        </v-row>
                    </v-card-item>
                    <v-tabs v-model="tab" show-arrows class="">
                        <v-tab
                            v-for="(mes, index) in meses"
                            :key="index"
                            :value="mes"
                            class="text-grey lighten-1 text-center"
                        >
                            {{ mes.slice(0, 3) }}
                        </v-tab>
                    </v-tabs>
                </v-card>

                <v-table class="border responsive">
                    <thead>
                        <tr class="">
                            <th>Producto</th>
                            <th>
                                Precio de <br />
                                venta
                            </th>
                            <th>
                                Costo de <br />
                                producción
                            </th>
                            <th>
                                Margen de <br />
                                ganancia
                            </th>

                            <th class="bg-primary text-white">
                                Proyección:
                                <br />
                                {{ tab }}
                            </th>
                            <th>
                                Total <br />
                                Ventas
                            </th>
                            <th>
                                Total <br />
                                Costos
                            </th>
                            <th>
                                Total <br />
                                Ganancias
                            </th>

                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in items"
                            :key="item[primaryKey]"
                        >
                            <td>
                                {{ item.prod_nombre }}
                            </td>
                            <td>S/. {{ item.prod_precio_venta.toFixed(2) }}</td>
                            <td>
                                S/. {{ item.prod_costo_produccion.toFixed(2) }}
                            </td>
                            <td>
                                <v-btn
                                    variant="text"
                                    :color="
                                        item.proy_margen_ganancia >= 0
                                            ? 'info'
                                            : 'error'
                                    "
                                >
                                    <span class="me-2">
                                        S/.
                                        {{
                                            item.proy_margen_ganancia.toFixed(2)
                                        }}
                                    </span>

                                    <v-badge
                                        dense
                                        class="text-caption"
                                        variant="tonal"
                                        size="small"
                                        :color="
                                            item.proy_margen_ganancia >= 0
                                                ? 'info'
                                                : 'error'
                                        "
                                        floating
                                        :content="
                                            item.proy_margen_ganancia_porcentaje
                                        "
                                    >
                                    </v-badge>
                                </v-btn>
                            </td>
                            <td
                                class="border border-primary"
                                style="width: 140px"
                            >
                                <v-window v-model="tab">
                                    <v-window-item
                                        v-for="(mes, mesIndex) in meses"
                                        :key="mesIndex"
                                        :value="mes"
                                    >
                                        <v-text-field
                                            v-model.number="
                                                item.proyd_cantidad_mensual[
                                                    mesIndex
                                                ]
                                            "
                                            class="text-center px-0"
                                            style="width: 100px"
                                            :clearable="false"
                                        ></v-text-field>
                                    </v-window-item>
                                </v-window>
                            </td>

                            <td class="text-end border">
                                S/.
                                {{
                                    (
                                        item.prod_precio_venta *
                                        item.proyd_cantidad_mensual.reduce(
                                            (a, b) => a + b,
                                            0
                                        )
                                    ).toFixed(2)
                                }}
                            </td>
                            <td class="text-end border">
                                S/.
                                {{
                                    (
                                        item.prod_costo_produccion *
                                        item.proyd_cantidad_mensual.reduce(
                                            (a, b) => a + b,
                                            0
                                        )
                                    ).toFixed(2)
                                }}
                            </td>
                            <td class="text-end border">
                                S/.
                                {{
                                    (
                                        item.proy_margen_ganancia *
                                        item.proyd_cantidad_mensual.reduce(
                                            (a, b) => a + b,
                                            0
                                        )
                                    ).toFixed(2)
                                }}
                            </td>
                            <td class="text-end border">
                                {{
                                    item.proyd_cantidad_mensual
                                        .reduce((a, b) => a + b, 0)
                                        .toFixed(0)
                                }}
                            </td>
                        </tr>

                        <!-- tr de totales al año -->
                        <tr class="bg-grey-lighten-3">
                            <td
                                colspan="5"
                                class="text-end border border-black"
                            >
                                Total: <strong>{{ year }} </strong>
                            </td>

                            <!-- calcular e total de ventas solo del mes del tab(diagos enero) -->
                            <td colspan="1" class="text-end border">
                                S/.
                                {{
                                    items
                                        .reduce((acc, item) => {
                                            return (
                                                acc +
                                                item.prod_precio_venta *
                                                    item.proyd_cantidad_mensual.reduce(
                                                        (a, b) => a + b,
                                                        0
                                                    )
                                            );
                                        }, 0)
                                        .toFixed(2)
                                }}
                            </td>
                            <!-- calcular e total de costos solo del mes del tab(diagos enero) -->
                            <td colspan="1" class="text-end border">
                                S/.
                                {{
                                    items
                                        .reduce((acc, item) => {
                                            return (
                                                acc +
                                                item.prod_costo_produccion *
                                                    item.proyd_cantidad_mensual.reduce(
                                                        (a, b) => a + b,
                                                        0
                                                    )
                                            );
                                        }, 0)
                                        .toFixed(2)
                                }}
                            </td>

                            <!-- calcular e total de ganancias solo del mes del tab(diagos enero) -->
                            <td colspan="1" class="text-end border">
                                S/.
                                {{
                                    items
                                        .reduce((acc, item) => {
                                            return (
                                                acc +
                                                item.proy_margen_ganancia *
                                                    item.proyd_cantidad_mensual.reduce(
                                                        (a, b) => a + b,
                                                        0
                                                    )
                                            );
                                        }, 0)
                                        .toFixed(2)
                                }}
                            </td>
                            <!-- calcular e total de cantidad solo del mes del tab(diagos enero) -->
                            <td class="text-end border">
                                {{
                                    items
                                        .reduce((acc, item) => {
                                            return (
                                                acc +
                                                item.proyd_cantidad_mensual.reduce(
                                                    (a, b) => a + b,
                                                    0
                                                )
                                            );
                                        }, 0)
                                        .toFixed(0)
                                }}
                            </td>
                        </tr>

                        <tr class="bg-primary">
                            <td colspan="5" class="text-end">
                                Total: <strong>{{ tab }} </strong>
                            </td>

                            <!-- calcular e total de ventas solo del mes del tab(diagos enero) -->
                            <td colspan="1" class="text-end fw-bold">
                                S/.
                                {{
                                    items
                                        .reduce((acc, item) => {
                                            return (
                                                acc +
                                                item.prod_precio_venta *
                                                    item.proyd_cantidad_mensual[
                                                        meses.indexOf(tab)
                                                    ]
                                            );
                                        }, 0)
                                        .toFixed(2)
                                }}
                            </td>
                            <!-- calcular e total de costos solo del mes del tab(diagos enero) -->
                            <td colspan="1" class="text-end fw-bold">
                                S/.{{
                                    items
                                        .reduce((acc, item) => {
                                            return (
                                                acc +
                                                item.prod_costo_produccion *
                                                    item.proyd_cantidad_mensual[
                                                        meses.indexOf(tab)
                                                    ]
                                            );
                                        }, 0)
                                        .toFixed(2)
                                }}
                            </td>

                            <!-- calcular e total de ganancias solo del mes del tab(diagos enero) -->
                            <td colspan="1" class="text-end fw-bold">
                                S/.
                                {{
                                    items
                                        .reduce((acc, item) => {
                                            return (
                                                acc +
                                                item.proy_margen_ganancia *
                                                    item.proyd_cantidad_mensual[
                                                        meses.indexOf(tab)
                                                    ]
                                            );
                                        }, 0)
                                        .toFixed(2)
                                }}
                            </td>
                            <!-- calcular e total de cantidad solo del mes del tab(diagos enero) -->
                            <td class="text-end">
                                {{
                                    items
                                        .reduce((acc, item) => {
                                            return (
                                                acc +
                                                item.proyd_cantidad_mensual[
                                                    meses.indexOf(tab)
                                                ]
                                            );
                                        }, 0)
                                        .toFixed(0)
                                }}
                            </td>
                        </tr>
                        <tr></tr>
                    </tbody>
                </v-table>
            </v-card>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import { router } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";

const props = defineProps({
    items: Object,
    anio: String,
});

const tab = ref("Enero");

const url = "/finanzas/proyecciones";
const primaryKey = "proy_id";

const year = ref(props.anio);
const yearOptions = ref([]);
for (let i = 2020; i <= 2100; i++) {
    yearOptions.value.push(i);
}

const loadingPage = ref(false);

const initPage = async () => {
    loadingPage.value = true;
    loadingPage.value = false;
};

const meses = [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre",
];


const save = () => {

    router.post(url, {
        anio: year.value,
        proyecciones: props.items,
    });
};
onMounted(() => {
    initPage();
});
</script>
