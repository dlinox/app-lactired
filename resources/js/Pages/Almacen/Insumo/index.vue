<template>
    <AdminLayout>
        <HeadingPage title="Insumos" subtitle="Lista de insumos">
            <template #actions>
                <BtnDialog title="Nuevo" width="500px">
                    <template v-slot:activator="{ dialog }">
                        <v-btn
                            @click="dialog"
                            prepend-icon="mdi-plus"
                            variant="flat"
                        >
                            Nuevo
                        </v-btn>
                    </template>
                    <template v-slot:content="{ dialog }">
                        <Formulario
                            :unitMeasurements="unitMeasurements"
                            @on-cancel="dialog"
                            :url="url"
                        />
                    </template>
                </BtnDialog>
            </template>
        </HeadingPage>

        <v-container fluid>
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
                            <BtnDialog title="Editar" width="500px">
                                <template v-slot:activator="{ dialog }">
                                    <v-btn
                                        color="info"
                                        icon
                                        variant="outlined"
                                        density="comfortable"
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
                                        :form-data="item"
                                        :unitMeasurements="unitMeasurements"
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
import { ref, onMounted } from "vue";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import BtnDialog from "@/components/BtnDialog.vue";
import DataTable from "@/components/DataTable.vue";
import DialogConfirm from "@/components/DialogConfirm.vue";
import Formulario from "./components/Formulario.vue";
import { itemsForSelect as getUnitMeasurements } from "@/Pages/Configuracion/Almacen/UnidadMedida/services/unitMeasurement.services";

const props = defineProps({
    items: Object,
    headers: Array,
    filters: Object,
    perPageOptions: Array,
});

const url = "/almacen/insumos";
const primaryKey = "insu_id";

const unitMeasurements = ref([]);
const loadingPage = ref(false);

const initPage = async () => {
    loadingPage.value = true;
    unitMeasurements.value = await getUnitMeasurements();
    loadingPage.value = false;
};
onMounted(() => {
    initPage();
});
</script>
