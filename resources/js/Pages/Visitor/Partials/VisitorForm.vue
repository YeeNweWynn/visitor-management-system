<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

defineProps({
    isUpdate: {
        type: Boolean,
        default: () => false,
    },
    visitor: {
        type: Object,
        default: () => [],
    },
});

const isUpdate = usePage().props.isUpdate;
const visitor = usePage().props.visitor;
const user = usePage().props.auth.user;

const form = useForm({
    email: visitor.email,
    name: visitor.name,
    phone_number: visitor.phone_number,
    address: visitor.address,
    postal_code: visitor.postal_code,
});

const handleSubmit = () => {
    if (isUpdate) {
        form.patch(route("visitor.update", visitor.id));
    } else {
        form.post(route("visitor.store"));
    }
};
const goBack = () => {
    window.history.back();
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Visitor Information
            </h2>

            <div v-if="isUpdate">
                <p class="mt-1 text-sm text-gray-600">
                    Update visitor account's profile information and email
                    address.
                </p>
            </div>
            <div v-else>
                <p class="mt-1 text-sm text-gray-600">
                    Create visitor account's profile information and email
                    address.
                </p>
            </div>
        </header>

        <form @submit.prevent="handleSubmit" class="mt-6 space-y-6">
            <input type="hidden" name="_token" :value="csrfToken" />
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="email"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="phone_number" value="Phone Number" />

                <TextInput
                    id="phone_number"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone_number"
                    required
                    autocomplete="tel"
                />

                <InputError class="mt-2" :message="form.errors.phone_number" />
            </div>

            <div>
                <InputLabel for="address" value="Address" />

                <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                    required
                    autofocus
                    autocomplete="address"
                />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div>
                <InputLabel for="postal_code" value="Postal Code" />

                <TextInput
                    id="postal_code"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.postal_code"
                    required
                    autocomplete="postal-code"
                />

                <InputError class="mt-2" :message="form.errors.postal_code" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                <SecondaryButton @click="goBack">Cancel</SecondaryButton>
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
