<template>
    <AdminLayout>
        <HeadingPage
            title="Inversiones"
            subtitle="Inversiones en productos y servicios"
        >
            <template #actions>
                <BtnDialog title="Nuevo" width="500px">
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
                            @on-cancel="dialog"
                            :url="url"
                            :form-data="{
                                inver_tipo: null,
                                inver_rubro: '',
                                inver_cantidad: 0,
                                inver_valor_unitario: 0,
                                inver_total: 0,
                                inver_periodo: null,
                            }"
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
                            <BtnDialog title="Editar" width="500px">
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
import DialogConfirm from "@/components/DialogConfirm.vue";
import DataTable from "@/components/DataTable.vue";
import Formulario from "./components/Formulario.vue";

const props = defineProps({
    items: Object,
    headers: Array,
    filters: Object,
    perPageOptions: Array,
});

const url = "/finanzas/inversiones";
const primaryKey = "inver_id";

const loadingPage = ref(false);

const initPage = async () => {
    loadingPage.value = true;
    loadingPage.value = false;
};
onMounted(() => {
    initPage();
});
</script>
