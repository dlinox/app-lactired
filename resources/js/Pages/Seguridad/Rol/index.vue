<template>
    <AdminLayout>
        <HeadingPage title="Roles" subtitle="Seguridad"> </HeadingPage>

        <v-container fluid class="pt-0">
            <v-card>
                <v-card-item>
                    <DataTable
                        :headers="data.headers"
                        :items="data.items"
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
                        <template v-slot:item.proc_plazo="{ item }">
                            {{ item.proc_plazo }} dia(s)
                        </template>
                        <template v-slot:item.documento="{ item }">
                            {{ item.documento.docu_nombre }}
                        </template>
                        <template v-slot:action="{ item }">
                            <BtnDialog title="Editar" width="600px">
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
                                        :formStructure="formStructure"
                                        :form-data="item"
                                        :edit="true"
                                        :url="url + '/' + item[`${primaryKey}`]"
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

                            <BtnDialog title="Asignar permisos" width="800px">
                                <template v-slot:activator="{ dialog }">
                                    <v-btn
                                        icon
                                        variant="outlined"
                                        density="comfortable"
                                        class="ml-1"
                                        color="dark"
                                        @click="dialog"
                                    >
                                        <v-icon
                                            size="x-small"
                                            icon="mdi-security-network"
                                        ></v-icon>
                                    </v-btn>
                                </template>
                                <template v-slot:content="{ dialog }">
                                    <FormPermisos
                                        @on-cancel="dialog"
                                        :permisos="permisos"
                                        :rolPermisos="item.permissions"
                                        :url="urlPermisos"
                                        :rol="item.id"
                                    />
                                </template>
                            </BtnDialog>
                        </template>
                    </DataTable>
                </v-card-item>
            </v-card>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import { router } from "@inertiajs/vue3";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import BtnDialog from "@/components/BtnDialog.vue";
import DataTable from "@/components/DataTable.vue";
import DialogConfirm from "@/components/DialogConfirm.vue";
import Formulario from "./components/Formulario.vue";
import FormPermisos from "./components/FormPermisos.vue";

const props = defineProps({
    data: Object,
    permisos: Object,
});

const url = "/seguridad/roles";
const urlPermisos = "/seguridad/permisos";

const primaryKey = "id";
const formStructure = [
    {
        key: "name",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "route_redirect",
        label: "Ruta base",
        type: "text",
        required: true,
        colMd: 12,
        default: "",
    },
];
</script>
