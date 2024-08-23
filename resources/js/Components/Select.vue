<script setup>
import { defineProps } from "vue";

const props = defineProps({
    modelValue: {
        type: [String, Number],
        required: true,
    },
    options: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["update:modelValue"]);

const updateValue = (event) => {
    emit("update:modelValue", event.target.value);
};
</script>

<template>
    <select
        :value="modelValue"
        @change="updateValue"
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    >
        <option
            v-for="option in options"
            :key="option.value"
            :value="option.value"
        >
            {{ option.label }}
        </option>
    </select>
</template>
