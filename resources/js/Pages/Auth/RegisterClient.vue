<template>
    <v-app id="inspire-auth" class="h-screen">
        <v-card width="600" class="mx-auto my-auto pt-5">
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <Logo class="mx-auto" :LogoWidth="200" />
                    </v-col>
                    <v-col cols="12" class="text-center pt-0">
                        <small class="mx-auto text-caption font-weight-bold"
                            >Sistema de productos lacteos</small
                        >
                    </v-col>

                    <v-col cols="12" class="text-center">
                        <h3 class="text-h5">Registrarme</h3>
                    </v-col>

                    <v-col cols="12" class="text-center">
                        <v-form ref="formRef" @submit.prevent="submit">
                            <v-row>
                                <v-col class="pb-0" cols="12" md="6">
                                    <v-text-field
                                        v-model="form.clie_nro_documento"
                                        class="mb-4"
                                        label="DNI"
                                        :errorMessages="form.errors.clie_nro_documento"
                                    />
                                </v-col>

                                <v-col class="pb-0" cols="12" md="6">
                                    <v-text-field
                                        v-model="form.clie_nombres"
                                        class="mb-4"
                                        label="Nombres"
                                    />
                                </v-col>

                                <v-col class="pb-0" cols="12" md="6">
                                    <v-text-field
                                        v-model="form.clie_paterno"
                                        class="mb-4"
                                        label="Apellido Paterno"
                                    />
                                </v-col>

                                <v-col class="pb-0" cols="12" md="6">
                                    <v-text-field
                                        v-model="form.clie_materno"
                                        class="mb-4"
                                        label="Apellido Materno"
                                    />
                                </v-col>

                                <v-col class="pb-0" cols="12" md="6">
                                    <v-text-field
                                        v-model="form.clie_telefono"
                                        class="mb-4"
                                        label="Celular"
                                    />
                                </v-col>

                                <v-col class="pb-0" cols="12" md="6">
                                    <v-text-field
                                        v-model="form.clie_correo"
                                        class="mb-4"
                                        label="Correo"
                                    />
                                </v-col>

                                <v-col cols="12">
                                    <v-btn
                                        type="submit"
                                        block
                                        :loading="form.processing"
                                    >
                                        Ingresar
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-col>
                </v-row>
            </v-container>
            <v-card-actions>
                <small class="px-4 text-center"
                    >LACTIRED v. 1.1 © 2023 todos los derechos reservados
                </small>
            </v-card-actions>
        </v-card>
    </v-app>
</template>
<script setup>
import { useForm } from "@inertiajs/vue3";
import Logo from "../../components/Logo.vue";

const form = useForm({
    clie_nombres: null,
    clie_paterno: null,
    clie_materno: null,
    clie_tipo_documento: "DNI",
    clie_nro_documento: null,
    clie_tipo_persona: 0,
    clie_direccion: "S/D",
    clie_telefono: null,
    clie_correo: null,
    clie_password: null,
});

const submit = async () => {
    form.post("registrar-cliente", {
        onError: (e) => {
            console.log(e);
        },
        onSuccess: (e) => {
            alert('Registro exitoso');
            form.reset();
            console.log(e);
            console.log("redireccionando");
        },
    });
};
</script>
