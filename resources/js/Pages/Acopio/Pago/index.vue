<template>
    <AdminLayout>
        <HeadingPage title="Pago de Acopio" subtitle="Consultar Pagos">
            <template #actions>
                <v-btn
                    @click="router.get('/acopio/pagos/create')"
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

                        <template v-slot:item.pago_estado="{ item }">
                            {{ item.pago_estado ? "ACTIVO" : "ANULADO" }}
                        </template>
                        <template v-slot:item.pago_ticket="{ item }">
                            <a
                                :href="item.pago_ticket"
                                target="_blank"
                                class="text-decoration-none"
                            >
                                <v-btn prepend-icon="mdi-file-pdf-box" color="red">
                                    ver
                                </v-btn>
                            </a>
                        </template>

                        <template v-slot:action="{ item }">
                            <v-btn
                                :disabled="!item.pago_estado"
                                variant="outlined"
                                class="ml-1"
                                color="red"
                                prepend-icon="mdi-cancel"
                            >
                                <DialogConfirm
                                    text="¿Seguro de anular la compra, el cambio sera permanente?"
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
import { Link, router, useForm } from "@inertiajs/vue3";
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

const url = "/acopio/pagos";
const primaryKey = "pago_id";
</script>
