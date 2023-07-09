<template>
    <v-form ref="formRef" @submit.prevent="submit">
        <v-row>
            <v-col
                v-for="(field, index) in formularioJson"
                :key="index"
                :cols="field.cols ?? 12"
                :md="field.colMd"
            >
                <slot :name="'field.' + field.key">
                    <template v-if="field.type === 'text'">
                        <v-text-field
                            v-model="form[`${field.key}`]"
                            :label="field.label"
                            :rules="field.required ? [isRequired] : []"
                            :error-messages="form.errors[`${field.key}`]"
                            :readonly="field.readonly"
                            :disabled="field.disabled"
                        ></v-text-field>
                    </template>
                    <template v-else-if="field.type === 'select'">
                        <v-select
                            v-model="form[`${field.key}`]"
                            :items="field.options"
                            :label="field.label"
                            :rules="field.required ? [isRequired] : []"
                        ></v-select>
                    </template>
                    <template v-else-if="field.type === 'number'">
                        <v-text-field
                            v-model="form[`${field.key}`]"
                            :label="field.label"
                            :rules="field.required ? [isRequired] : []"
                            type="number"
                        ></v-text-field>
                    </template>
                    <template v-else-if="field.type === 'textarea'">
                        <v-textarea
                            v-model="form[`${field.key}`]"
                            :label="field.label"
                            :rules="field.required ? [isRequired] : []"
                            :error-messages="form.errors[`${field.key}`]"
                        ></v-textarea>
                    </template>

                    <template v-else-if="field.type === 'checkbox'">
                        <v-checkbox
                            v-model="form[`${field.key}`]"
                            :label="field.label"
                            :rules="field.required ? [isRequired] : []"
                            :error-messages="form.errors[`${field.key}`]"
                        ></v-checkbox>
                    </template>

                    <template v-else-if="field.type === 'autocomplete'">
                        <simple-autocomplete
                            :url="field.url"
                            :item-title="field.itemTitle"
                            :item-value="field.itemValue"
                            :label="field.label"
                            v-model="form[`${field.key}`]"
                            :rules="field.required ? [isRequired] : []"
                            :error-messages="form.errors[`${field.key}`]"
                        />
                    </template>
                </slot>
            </v-col>
            <v-col cols="12" class="d-flex flex-row-reverse">
                <slot name="actions">
                    <v-btn
                        type="submit"
                        class="ms-2"
                        :loading="form.processing"
                        :disabled="!form.isDirty"
                        >Guardar</v-btn
                    >
                    <v-btn
                        variant="tonal"
                        color="red"
                        @click="$emit('onCancel')"
                    >
                        cancelar
                    </v-btn>
                </slot>
            </v-col>
        </v-row>
    </v-form>
</template>
<script setup>
import { computed, ref } from "vue";
import { isRequired } from "@/helpers/validations.js";
import SimpleAutocomplete from "@/components/SimpleAutocomplete.vue";
const props = defineProps({
    formularioJson: Array,
    modelValue: Object,
});

const emit = defineEmits(["update:modelValue", "onCancel", "onSumbit"]);

const formRef = ref(null);

const form = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

const submit = async () => {
    const { valid } = await formRef.value.validate();
    if (!valid) return;
    emit("onSumbit");
};
</script>
