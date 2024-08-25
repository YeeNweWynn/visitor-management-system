<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const urlParams = new URLSearchParams(window.location.search);

const form = useForm({
    name: urlParams.get("name") || "",
    email: urlParams.get("email") || "",
    phone_number: urlParams.get("phone_number") || "",
});

const searchVisitor = () => {
    const params = Object.fromEntries(
        Object.entries({
            name: form.name,
            email: form.email,
            phone_number: form.phone_number,
        }).filter(([key, value]) => value && value.trim() !== "")
    );

    const searchParams = new URLSearchParams(params).toString();

    form.get(
        route("visitor.index") + (searchParams ? `?${searchParams}` : ""),
        {
            onError: () => {
                console.log("Visitor search failed");
            },
        }
    );
};

const clearFilters = () => {
    form.name = "";
    form.email = "";
    form.phone_number = "";
    form.get(route("visitor.index"), {
        replace: true,
        preserveState: false,
        onSuccess: () => {
            window.history.replaceState(
                {},
                document.title,
                route("visitor.index")
            );
        },
        onError: () => {
            console.log("Clear filter failed");
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Search Visitor</h2>
            <p class="mt-1 text-sm text-gray-600">
                Search visitor by name or email or phone number
            </p>
        </header>

        <div class="mt-6 space-y-6">
            <div class="flex flex-col md:flex-row">
                <div class="w-full flex-1 mx-2">
                    <TextInput
                        v-model="form.name"
                        placeholder="Visitor Name"
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                    />
                </div>

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

                <div
                    class="w-full flex-1 flex flex-wrap items-end space-x-2 space-y-2 md:space-y-0 mx-2"
                >
                    <PrimaryButton
                        :disabled="form.processing"
                        @click="searchVisitor"
                        >Search</PrimaryButton
                    >
                    <SecondaryButton
                        :disabled="form.processing"
                        @click="clearFilters"
                        >Clear</SecondaryButton
                    >
                </div>
            </div>
        </div>
    </section>
</template>
