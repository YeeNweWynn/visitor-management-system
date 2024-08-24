<script setup>
import Pagination from "@/Components/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import CheckinModal from "@/Components/CheckinModal.vue";
import { Link, usePage, router } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    visitors: {
        type: Array,
        default: () => [],
    },
});

const headers = ["Name", "Email", "Phone", "Address", "Postal Code", "Action"];
const visitors = usePage().props.visitors.data;
const checkinTypes = usePage().props.checkinTypes;
const purposeOfVisit = usePage().props.purposeOfVisit;
const showModal = ref(false);
const selectedVisitorId = ref(0);
const openCheckinModal = (visitorId) => {
    selectedVisitorId.value = visitorId;
    showModal.value = true;
};
const closeCheckinModal = () => {
    showModal.value = false;
};
const checkinVisitor = (data) => {
    router.post(
        "/checkin",
        {
            visitor_id: data.visitorId,
            type: data.type,
            vehicle_number: data.vehicle_number,
            purpose_of_visit: data.purpose_of_visit,
        },
        {
            onSuccess: () => {
                showModal.value = false;
                window.location.reload();
            },
            onError: (errors) => {
                console.error("Error:", errors);
            },
        }
    );
};
const checkoutVisitor = (checkinId) => {
    router.patch(
        `/checkin/${checkinId}?source=visitor`,
        {},
        {
            onSuccess: () => {
                window.location.reload();
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
                <tr v-for="visitor in visitors" :key="visitor.id">
                    <td class="border px-6 py-6">{{ visitor.name }}</td>
                    <td class="border px-6 py-4">
                        <Link
                            :href="'visitor/' + visitor.id"
                            class="underline text-sm text-blue-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            {{ visitor.email }}
                        </Link>
                    </td>
                    <td class="border px-6 py-4">
                        {{ visitor.phone_number }}
                    </td>
                    <td class="border px-6 py-4">{{ visitor.address }}</td>
                    <td class="border px-6 py-4">
                        {{ visitor.postal_code }}
                    </td>
                    <td class="border px-6 py-4">
                        <PrimaryButton
                            v-if="visitor.check_ins.length == 0"
                            @click="openCheckinModal(visitor.id)"
                        >
                            Checkin
                        </PrimaryButton>
                        <DangerButton
                            v-else
                            @click="checkoutVisitor(visitor.check_ins[0].id)"
                        >
                            Checkout
                        </DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <Pagination class="mt-6" :links="usePage().props.visitors.links" />
    <CheckinModal
        :show="showModal"
        :visitor-id="selectedVisitorId"
        :checkin-types="checkinTypes"
        :purpose-of-visit="purposeOfVisit"
        @close="closeCheckinModal"
        @submit="checkinVisitor"
    />
</template>
