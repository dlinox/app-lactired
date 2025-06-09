<template>
    <v-autocomplete
        v-model="select"
        v-model:search="search"
        :loading="loading"
        :items="items"
        :item-title="itemTitle"
        :item-value="itemValue"
        :label="label"
        open-on-clear
        :no-data-text="
            search == ''
                ? 'Ingrese los terminos de busqueda'
                : 'No hay resultados'
        "
        :error-messages="errorMessages"
        @update:search="handleSearch"
    >
        <template v-if="itemCustom" v-slot:item="{ props, item }">
            <slot name="custom" :props="props" :item="item"> </slot>
        </template>
    </v-autocomplete>
</template>
<script setup>
import axios from "axios";
import { ref } from "vue";
import { debounce } from "lodash";
import { computed } from "vue";
const emit = defineEmits(["update:modelValue"]);
const props = defineProps({
    url: String,
    itemTitle: String,
    itemValue: String,
    label: String,
    modelValue: [Number, Array, String],
    itemCustom: Boolean,
    itemsDefault: [],
    errorMessages: null,
});

const loading = ref(false);
const items = ref([]);
const search = ref("");

const select = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

const handleSearch = debounce(async (val) => {
    if (val == select.value) return;
    if (val == null || val == "") return;

    // if (select.value) {
    //     console.log(select.value);

    //     let currentSelect = items.value.filter(
    //         (item) => item[`${props.itemValue}`] == select.value
    //     );
    //     if (currentSelect[0]?.[`${props.itemTitle}`] == search.value) return;
    // }

    loading.value = true;
    let res = await axios.get(props.url, { params: { search: val } });
    console.log("data", res.data);
    items.value = res.data;

    loading.value = false;
}, 600);

const initComponent = () => {
    if (props.itemsDefault.length > 0) {
        select.value = props.itemsDefault[0][`${props.itemValue}`];
    } else {
        select.value = null;
    }
};
</script>
