<script setup>
import Container from "../../components/Container.vue";
import TextLink from "../../components/TextLink.vue";
import InputField from "../../components/InputField.vue";
import PrimaryBtn from "../../components/PrimaryBtn.vue";
import ErrorMessage from "../../components/ErrorMessage.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    password: "",
});

const submit = () => {
    form.post(route("password.confirm"), {
        onError: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Confirm Password" />
    <Container class="w-1/2">
        <p class="text-center text-md mb-8">Please confirm your password before continuing</p>
       
        <ErrorMessage :errors="form.errors" />

        <form @submit.prevent="submit" class="space-y-6">
            <InputField
                label="Password"
                type="password"
                icon="key"
                v-model="form.password"
            />

            <div class="flex items-center justify-end">
                <TextLink
                    routeName="password.request"
                    label="Forgot Password?"
                />
            </div>

            <PrimaryBtn class="block w-full" :disabled="form.processing">Confirm Password</PrimaryBtn>
        </form>
    </Container>
</template>
