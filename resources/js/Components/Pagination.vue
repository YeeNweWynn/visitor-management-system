<script setup>
import { Link } from "@inertiajs/vue3";
const { URLSearchParams } = window;

const props = defineProps({
    links: {
        type: Array,
        default: () => [],
    },
    searchParams: {
        type: Object,
        default: () => ({}),
    },
});

function buildSearchParams(params) {
    const searchParams = new URLSearchParams();
    for (const key in params) {
        if (params[key] !== null && params[key] !== "") {
            searchParams.append(key, params[key]);
        }
    }
    return searchParams.toString();
}
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, p) in links" :key="p">
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label"
                />
                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                    :class="{ 'bg-blue-700 text-white': link.active }"
                    :href="`${link.url}${
                        link.url.includes('?') ? '&' : '?'
                    }${buildSearchParams(props.searchParams)}&page=${
                        link.label
                    }`"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
