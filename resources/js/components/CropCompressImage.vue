<template>
    <v-btn
        class="btn-upload-image"
        :loading="btn_loading"
        prepend-icon="mdi-tray-arrow-up"
        block
        color="secondary"
    >
        <input
            type="file"
            ref="file"
            @change="cargarImagen($event)"
            accept="image/*"
        />
        Imagen
    </v-btn>

    <v-dialog v-model="showModal" width="600px">
        <v-card>
            <v-toolbar title="Imagen">
                <v-spacer></v-spacer>

                <v-btn
                    v-if="isMovable"
                    @click="movable = !movable"
                    :active="movable"
                    density="compact"
                    rounded="0"
                    icon="mdi-cursor-move"
                    variant="text"
                    color="black"
                ></v-btn>
                <v-btn
                    v-if="isResizable"
                    @click="resizable = !resizable"
                    :active="resizable"
                    density="compact"
                    rounded="0"
                    icon="mdi-arrow-expand"
                    variant="text"
                    color="black"
                ></v-btn>

                <v-menu v-if="isAspectRatio">
                    <template v-slot:activator="{ props }">
                        <v-btn
                            rounded="0"
                            density="comfortable"
                            variant="outlined"
                            color="primary"
                            v-bind="props"
                            prepend-icon="mdi-aspect-ratio"
                        >
                            {{
                                aspectRatio_options.find(
                                    (item) => item.key == _aspectRatio
                                ).label
                            }}
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item
                            v-for="(item, index) in aspectRatio_options"
                            :key="item.key"
                            :value="item.key"
                            @click="_aspectRatio = item.key"
                        >
                            <v-list-item-title>
                                {{ item.label }}
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-toolbar>

            <v-container>
                <cropper
                    ref="cropperRef"
                    :src="image.src"
                    :stencil-props="{
                        aspectRatio: _aspectRatio,
                        movable: movable,
                        resizable: resizable,
                    }"
                />
            </v-container>
            <v-card-actions class="py-3">
                <v-spacer></v-spacer>
                <v-btn @click="showModal = false" color="pink" variant="tonal">
                    Cancelar
                </v-btn>
                <v-btn @click="cropAndOptimize" variant="flat">
                    Cortar y guardar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, reactive } from "vue";
import { Cropper } from "vue-advanced-cropper";
import { loadImageHelper } from "@/helpers/uploadFile.js";
const emits = defineEmits(["onCropper"]);

const props = defineProps({
    mimeType: String,
    optimize: {
        type: Number,
        default: 0.6,
    },
    aspectRatio: {
        type: Number,
        default: 16 / 9,
    },
    isMovable: {
        type: Boolean,
        default: true,
    },
    isResizable: {
        type: Boolean,
        default: true,
    },
    isAspectRatio: {
        type: Boolean,
        default: true,
    },
});

const _aspectRatio = ref(props.aspectRatio);
const movable = ref(true);
const resizable = ref(true);

const aspectRatio_options = [
    { label: "21:9", key: 21 / 9 },
    { label: "16:9", key: 16 / 9 },
    { label: "4:3", key: 4 / 3 },
    { label: "1:1", key: 1 },
    { label: "Libre", key: 0 },
];

const showModal = ref(false);
const btn_loading = ref(false);

const cropperRef = ref(null);

const image = reactive({
    src: null,
    type: null,
});

const cropAndOptimize = () => {
    const canvas = cropperRef.value.getResult().canvas;
    canvas.toBlob(
        (blob) => {
            let file = new File([blob], "imagen_crop_optimize", {
                type: blob.type,
                quality: 0.5,
            });
            emits("onCropper", { file: file, blob: URL.createObjectURL(blob) });
            showModal.value = false;
        },
        image.type,
        0.6
    );
};

const cargarImagen = async (e) => {
    console.log("ini");
    btn_loading.value = true;
    let res = await loadImageHelper(e);

    if (res) {
        image.src = res.src;
        image.type = res.type;

        showModal.value = true;
    } else {
        console.log("error");
    }

    console.log("fin");
    btn_loading.value = false;
};
</script>

<style lang="scss">
.btn-upload-image {
    position: relative;

    input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        font-size: 0;
        cursor: pointer;
        opacity: 0;
    }
}
.upload-example-cropper {
    overflow: hidden;
    width: 100%;
    height: 100%;
}
</style>
