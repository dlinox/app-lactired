<template>
    <AdminLayout>
        <HeadingPage title="Procuctos" subtitle="Tipos de productos">
            <template #actions>
                <BtnDialog title="Nuevo" width="700px">
                    <template v-slot:activator="{ dialog }">
                        <v-btn
                            @click="dialog"
                            prepend-icon="mdi-plus"
                            variant="flat"
                            :loading="loadingPage"
                        >
                            Nuevo
                        </v-btn>
                    </template>
                    <template v-slot:content="{ dialog }">
                        <Formulario
                            :productTypes="productTypes"
                            :unitMeasurements="unitMeasurements"
                            @on-cancel="dialog"
                            :url="url"
                        />
                    </template>
                </BtnDialog>
            </template>
        </HeadingPage>
        <v-container fluid class="pt-0">
            <v-card>
                <v-card-item>
                    <DataTable
                        :headers="headers"
                        :items="items"
                        with-action
                        :url="url"
                    >
                        <template v-slot:header="{ filter }">
                            <v-row class="py-3" justify="end">
                                <v-col cols="6">
                                    <v-text-field
                                        v-model="filter.search"
                                        label="Buscar"
                                    />
                                </v-col>
                            </v-row>
                        </template>

                        <template v-slot:action="{ item }">
                            <BtnDialog
                                title="Insumos para la preparación de este producto"
                                width="900px"
                            >
                                <template v-slot:activator="{ dialog }">
                                    <v-btn
                                        color="dark"
                                        icon
                                        class="me-1"
                                        variant="outlined"
                                        density="comfortable"
                                        @click="dialog"
                                    >
                                        <v-icon
                                            size="x-small"
                                            icon="mdi-basket-fill"
                                        />
                                    </v-btn>
                                </template>
                                <template v-slot:content="{ dialog }">
                                    <InsumoForm
                                        @on-cancel="dialog"
                                        :unitMeasurements="unitMeasurements"
                                        :productId="item[`${primaryKey}`]"
                                        :productName="item.prod_nombre"
                                        :url="url"
                                    />
                                </template>
                            </BtnDialog>

                            <BtnDialog title="Editar" width="700px">
                                <template v-slot:activator="{ dialog }">
                                    <v-btn
                                        color="info"
                                        icon
                                        variant="outlined"
                                        density="comfortable"
                                        :loading="loadingPage"
                                        @click="dialog"
                                    >
                                        <v-icon
                                            size="x-small"
                                            icon="mdi-pencil"
                                        ></v-icon>
                                    </v-btn>
                                </template>
                                <template v-slot:content="{ dialog }">
                                    <Formulario
                                        @on-cancel="dialog"
                                        :productTypes="productTypes"
                                        :unitMeasurements="unitMeasurements"
                                        :form-data="item"
                                        :edit="true"
                                        :url="url"
                                    />
                                </template>
                            </BtnDialog>

                            <v-btn
                                icon
                                variant="outlined"
                                density="comfortable"
                                class="ml-1"
                                color="red"
                            >
                                <DialogConfirm
                                    @onConfirm="
                                        () =>
                                            router.delete(
                                                url +
                                                    '/' +
                                                    item[`${primaryKey}`]
                                            )
                                    "
                                />
                                <v-icon
                                    size="x-small"
                                    icon="mdi-delete-empty"
                                ></v-icon>
                            </v-btn>
                        </template>
                    </DataTable>
                </v-card-item>
            </v-card>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import { router } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import BtnDialog from "@/components/BtnDialog.vue";
import DataTable from "@/components/DataTable.vue";
import DialogConfirm from "@/components/DialogConfirm.vue";
import Formulario from "./components/Formulario.vue";
import InsumoForm from "./components/InsumoForm.vue";
import { itemsForSelect as getProductTypes } from "@/Pages/Configuracion/Almacen/TipoProducto/services/productTypes.services.js";
import { itemsForSelect as getUnitMeasurements } from "@/Pages/Configuracion/Almacen/UnidadMedida/services/unitMeasurement.services";

const props = defineProps({
    items: Object,
    headers: Array,
    filters: Object,
    perPageOptions: Array,
});

const url = "/almacen/productos";
const primaryKey = "prod_id";

const productTypes = ref([]);
const unitMeasurements = ref([]);
const loadingPage = ref(false);

const initPage = async () => {
    loadingPage.value = true;
    productTypes.value = await getProductTypes();
    unitMeasurements.value = await getUnitMeasurements();
    loadingPage.value = false;
};
onMounted(() => {
    initPage();
});
</script>
