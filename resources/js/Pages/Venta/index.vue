<template>
    <AdminLayout>
        <HeadingPage title="Ventas" subtitle="Consultar">
            <template #actions>
                <v-btn
                    @click="router.get('/ventas/create')"
                    prepend-icon="mdi-plus"
                    variant="flat"
                >
                    Nuevo
                </v-btn>
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

                        <template v-slot:item.vent_estado="{ item }">
                            {{ item.vent_estado ? "ACTIVO" : "ANULADO" }}
                        </template>

                        <template v-slot:action="{ item }">
                            <v-btn
                                :disabled="!item.vent_estado"
                                variant="outlined"
                                density="comfortable"
                                class="ml-1"
                                color="red"
                                prepend-icon="mdi-cancel"
                            >
                                <DialogConfirm
                                    text="¿Seguro de anular la venta, el cambio sera permanente?"
                                    @onConfirm="
                                        () =>
                                            router.delete(
                                                url +
                                                    '/' +
                                                    item[`${primaryKey}`]
                                            )
                                    "
                                />
                                Anular
                            </v-btn>
                        </template>
                    </DataTable>
                </v-card-item>
            </v-card>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import { router, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import DataTable from "@/components/DataTable.vue";
import DialogConfirm from "@/components/DialogConfirm.vue";

const props = defineProps({
    items: Object,
    headers: Array,
    filters: Object,
    perPageOptions: Array,
});

const url = "/ventas";
const primaryKey = "vent_id";
</script>
