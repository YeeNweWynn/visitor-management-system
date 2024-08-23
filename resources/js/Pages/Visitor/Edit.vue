<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import VisitorForm from './Partials/VisitorForm.vue';
import { Head, Link, usePage  } from '@inertiajs/vue3';

defineProps({
    isUpdate: {
        type: Boolean,
        default: () => false,
    },
});

</script>

<template>
    <Head title="Visitor" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Visitor</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <VisitorForm 
                    :is-update="isUpdate"
                    class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
