<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Listing from "./Partials/Listing.vue";
import Search from "./Partials/Search.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Visitors" />

    <AuthenticatedLayout>
        <template #header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h2
                            class="font-semibold text-xl text-gray-800 leading-tight"
                        >
                            Visitors
                        </h2>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <Link
                            href="visitor/create"
                            as="button"
                            type="button"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Create
                        </Link>
                    </div>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <Search />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <Listing class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
