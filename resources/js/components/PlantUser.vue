<template>
    <v-btn
        variant="tonal"
        color="dark"
        prepend-icon="mdi-domain"
        density="comfortable"
    >
        <small
            style="
                max-width: 200px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            "
        >
            {{ user.user_plan_nombre }}
        </small>
    </v-btn>
    <v-btn
        icon="mdi-sync"
        color="info"
        variant="flat"
        density="compact"
        @click="getPlants"
    >
    </v-btn>

    <v-dialog v-model="dialog" width="600px" max-height="500px">
        <v-card>
            <v-toolbar density="compact" title="Cambiar planta" />
            <template v-if="items.length === 0">
                <v-card-item class="py-8">
                    <v-progress-linear
                        class="w-50"
                        indeterminate
                    ></v-progress-linear>
                </v-card-item>
            </template>
            <template v-else>
                <v-list color="blue">
                    <v-list-item
                        v-for="item in items"
                        :key="item.id"
                        :title="`${item.id} - ${item.name }`"
                        :value="item.id"
                        :active="item.id === user?.user_plan_id  ? true : false"
                        @click="changePlant(item)"
                    />
                </v-list>
            </template>
        </v-card>
    </v-dialog>
</template>
<script setup>
import { router } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({ user: Object });
const dialog = ref(false);

const items = ref([]);

const getPlants = async () => {
    if (dialog.value) return;
    dialog.value = true;
    let res = await axios.get("/plantas/all");
    items.value = res.data;
};
const changePlant = async (item) => {
    router.visit("/plantas/change", {
        method: "post",
        data: { ...item },
        replace: true,
        preserveState: false,
        preserveScroll: false,
    });
    // let res = await axios.post("/plantas/change", { ...item });
};
</script>
