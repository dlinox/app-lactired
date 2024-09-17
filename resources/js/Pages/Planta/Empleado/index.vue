<template>
    <AdminLayout>
        <HeadingPage title="Colaboradores" subtitle="Lista de trabajadores ">
            <template #actions>
                <BtnDialog title="Nuevo" width="800px">
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
                            :formStructure="formStructure"
                            :url="url"
                            @on-cancel="dialog"
                        />
                    </template>
                </BtnDialog>
            </template>
        </HeadingPage>

        <v-container fluid>
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

                        <template v-slot:action="{ item }">
                            <BtnDialog
                                :title="'Editar ' + item.empl_nombres"
                                width="800px"
                            >
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
                                        :formStructure="formStructure"
                                        @on-cancel="dialog"
                                        :form-data="item"
                                        :edit="true"
                                        :url="`${url}/${item[`${primaryKey}`]}`"
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
                                                `${url}/${
                                                    item[`${primaryKey}`]
                                                }`
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
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import BtnDialog from "@/components/BtnDialog.vue";
import DataTable from "@/components/DataTable.vue";
import DialogConfirm from "@/components/DialogConfirm.vue";
import Formulario from "./components/Formulario.vue";

const props = defineProps({
    data: Object,
    cargos: Array,
    profesiones: Array,
    gradosInstruccion: Array,
});

const url = "/plantas/empleados";
const primaryKey = "empl_id";

const sexoItems = [
    { value: "M", title: "Masculino" },
    { value: "F", title: "Femenino" },
];

const formStructure = [
    {
        key: "empl_dni",
        label: "DNI",
        type: "text",
        required: true,
        colMd: 4,
        cols: 12,
        default: "",
    },
    {
        key: "empl_nombres",
        label: "Nombre",
        type: "text",
        required: true,
        colMd: 8,
        cols: 12,
        default: "",
    },

    {
        key: "empl_paterno",
        label: "A. Paterno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },

    {
        key: "empl_materno",
        label: "A. Materno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },
    {
        key: "empl_email",
        label: "Correo",
        type: "email",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },

    {
        key: "empl_telefono",
        label: "Telefono / Celular",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },

    {
        key: "empl_fecha_nac",
        label: "Fecha de Nacimiento",
        type: "date",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },

    {
        key: "empl_sexo",
        label: "Sexo",
        type: "select",
        options: sexoItems,
        required: true,
        colMd: 6,
        default: "M",
    },

    {
        key: "empl_gins_id",
        label: "Grado de instruccion",
        type: "combobox",
        options: props.gradosInstruccion,
        itemTitle: "gins_nombre",
        itemValue: "gins_id",
        required: true,
        colMd: 6,
        default: null,
    },
    {
        key: "empl_prof_id",
        label: "Profesion",
        type: "combobox",
        options: props.profesiones,
        itemTitle: "prof_nombre",
        itemValue: "prof_id",
        required: true,
        colMd: 6,
        default: null,
    },

    {
        key: "empl_carg_id",
        label: "Cargo",
        type: "combobox",
        options: props.cargos,
        itemTitle: "carg_nombre",
        itemValue: "carg_id",
        required: true,
        colMd: 12,
        default: null,
    },
];
</script>
