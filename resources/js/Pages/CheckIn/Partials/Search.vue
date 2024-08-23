<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Select from "@/Components/Select.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

const user = usePage().props.auth.user;
const visitStatus = usePage().props.visitStatus;
const searchParams = usePage().props.searchParams || {};

const form = useForm({
    email: searchParams.email || "",
    phone_number: searchParams.phone_number || "",
    status: searchParams.status || "all",
    checked_in_at: searchParams.checked_in_at || "",
    checked_out_at: searchParams.checked_out_at || "",
});

const searchCheckin = () => {
    const params = Object.fromEntries(
        Object.entries({
            email: form.email,
            phone_number: form.phone_number,
            status: form.status,
            checked_in_at: form.checked_in_at,
            checked_out_at: form.checked_out_at,
        }).filter(([key, value]) => value && value.trim() !== "")
    );

    const searchParams = new URLSearchParams(params).toString();
    form.get(
        route("checkin.index") + (searchParams ? `?${searchParams}` : ""),
        {
            onSuccess: () => {
                console.log("success");
            },
            onError: () => {
                console.log("error");
            },
        }
    );
};

const clearFilters = () => {
    form.email = "";
    form.phone_number = "";
    form.status = "all";
    form.checked_in_at = "";
    form.checked_out_at = "";
    form.get(route("checkin.index"), {
        replace: true,
        preserveState: false,
        onSuccess: () => {
            console.log("filters cleared");
            window.history.replaceState(
                {},
                document.title,
                route("checkin.index")
            );
        },
        onError: () => {
            console.log("error clearing filters");
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Search Check In</h2>

            <p class="mt-1 text-sm text-gray-600">
                Search check in by phone number or email or status or date
            </p>
        </header>

        <div class="mt-6 space-y-6">
            <div class="flex flex-col md:flex-row">
                <div class="w-full flex-1 mx-2">
                    <TextInput
                        v-model="form.email"
                        placeholder="visitor@mail.com"
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                    />
                </div>
                <div class="w-full flex-1 mx-2">
                    <TextInput
                        v-model="form.phone_number"
                        id="phone_number"
                        type="email"
                        placeholder="94XXXXXX"
                        class="mt-1 block w-full"
                    />
                </div>
                <div class="w-full flex-1 mx-2">
                    <div class="mb-4">
                        <Select v-model="form.status" :options="visitStatus" />
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row mt-4">
                <div class="w-full flex-1 mx-2">
                    <InputLabel for="check_in_date" value="Check-in Date" />

                    <TextInput
                        v-model="form.checked_in_at"
                        id="check_in_date"
                        type="date"
                        placeholder="Check-in Date"
                        class="mt-1 block w-full"
                    />
                </div>
                <div class="w-full flex-1 mx-2">
                    <InputLabel for="check_out_date" value="Check-out Date" />
                    <TextInput
                        v-model="form.checked_out_at"
                        id="check_out_date"
                        type="date"
                        placeholder="Check-out Date"
                        class="mt-1 block w-full"
                    />
                </div>
                <div
                    class="w-full flex-1 flex flex-wrap items-end space-x-2 space-y-2 md:space-y-0 mx-2"
                >
                    <PrimaryButton
                        class="h-10"
                        :disabled="form.processing"
                        @click="searchCheckin"
                        >Search</PrimaryButton
                    >
                    <SecondaryButton
                        class="h-10"
                        :disabled="form.processing"
                        @click="clearFilters"
                        >Clear</SecondaryButton
                    >
                </div>
            </div>
        </div>
    </section>
</template>
