<script setup>
import Pagination from "@/Components/Pagination.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { Link, useForm, usePage, router } from "@inertiajs/vue3";
import { format } from "date-fns";

defineProps({
    checkIns: {
        type: Array,
        default: () => [],
    },
});

const headers = [
    "Name",
    "Email",
    "Phone",
    "Type",
    "In",
    "Out",
    "Reason",
    "Action",
];
const checkIns = usePage().props.checkIns.data;
const searchParams = usePage().props.searchParams || {};

const formatDate = (dateString) => {
    if (!dateString) {
        return "-";
    }
    return format(new Date(dateString), "yyyy-MM-dd HH:mm:ss");
};

const checkoutVisitor = (checkinId) => {
    router.patch(
        `/checkin/${checkinId}`,
        {},
        {
            onSuccess: (page) => {
                console.log("Checkout success!");
            },
            onError: (errors) => {
                console.error("Error:", errors);
            },
        }
    );
};
</script>

<template>
    <div class="py-2">
        <p v-if="$page.props.flash.success" class="text-green-500">
            {{ $page.props.flash.success }}
        </p>
        <p v-if="$page.props.flash.error" class="text-red-500">
            {{ $page.props.flash.error }}
        </p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full whitespace-no-wrapw-full whitespace-no-wrap">
            <thead>
                <tr class="text-center font-bold">
                    <th
                        v-for="header in headers"
                        :key="header"
                        class="border px-6 py-4"
                    >
                        {{ header }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="checkIn in checkIns" :key="checkIn.id">
                    <td class="border px-6 py-4">
                        {{ checkIn.visitor?.name }}
                    </td>
                    <td class="border px-6 py-4">
                        {{ checkIn.visitor?.email }}
                    </td>
                    <td class="border px-6 py-4">
                        {{ checkIn.visitor?.phone_number }}
                    </td>
                    <td
                        v-if="checkIn.type == 'vehicle'"
                        class="border px-6 py-4"
                    >
                        {{ checkIn.type.toUpperCase() }} ({{
                            checkIn.vehicle_number
                        }})
                    </td>
                    <td v-else class="border px-6 py-4">
                        {{ checkIn.type.toUpperCase() }}
                    </td>
                    <td class="border px-6 py-4">
                        {{ formatDate(checkIn.checked_in_at) }}
                    </td>
                    <td class="border px-6 py-4">
                        {{ formatDate(checkIn.checked_out_at) }}
                    </td>
                    <td class="border px-6 py-4">
                        {{ checkIn.purpose_of_visit.toUpperCase() }}
                    </td>
                    <td class="border px-6 py-4">
                        <DangerButton
                            v-if="checkIn.checked_out_at == null"
                            @click="checkoutVisitor(checkIn.id)"
                        >
                            Checkout
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <Pagination
        class="mt-6"
        :links="usePage().props.checkIns.links"
        :search-params="searchParams"
    />
</template>
