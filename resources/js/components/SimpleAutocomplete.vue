<template>
    <v-autocomplete
        v-model="select"
        v-model:search="search"
        :loading="loading"
        :items="items"
        :item-title="itemTitle"
        :item-value="itemValue"
        :label="label"
        :no-data-text="
            search == ''
                ? 'Ingrese los terminos de busqueda'
                : 'No hay resultados'
        "
    >
        <template v-if="itemCustom" v-slot:item="{ props, item }">
            <slot name="custom" :props="props" :item="item"> </slot>
        </template>
    </v-autocomplete>
</template>
<script setup>
import axios from "axios";
import { watch, ref } from "vue";
import { throttle, debounce } from "lodash";
import { computed } from "vue";
const emit = defineEmits(["update:modelValue"]);
const props = defineProps({
    url: String,
    itemTitle: String,
    itemValue: String,
    label: String,
    modelValue: [Number, Array, String],
    itemCustom: Boolean,
    itemsDefault: {
        type: [Array, Object],
        default: null,
    },
});

const loading = ref(false);
const items = ref([props.itemsDefault]);
const search = ref("");

const select = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

watch(
    search,
    throttle(async (val) => {
        if (val == null || val == "") return;

        if (select.value) {
            let currentSelect = items.value.filter(
                (item) => item[`${props.itemValue}`] == select.value
            );
            if (currentSelect[0]?.[`${props.itemTitle}`] == search.value)
                return;
        }

        loading.value = true;
        let res = await axios.get(props.url, { params: { search: val } });
        console.log("data", res.data);
        items.value = res.data;

        loading.value = false;
    }, 600)
);
</script>
