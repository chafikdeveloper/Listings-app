<script setup>
import Container from "../../components/Container.vue";
import Title from "../../components/Title.vue";
import TextLink from "../../components/TextLink.vue";
import InputField from "../../components/InputField.vue";
import PrimaryBtn from "../../components/PrimaryBtn.vue";
import ErrorMessage from "../../components/ErrorMessage.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
})

const submit = () => {
    form.post(route('register'), {
        onError: () => form.reset("password", "password_confirmation")
    })
}
</script>

<template>
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Register a new Account</Title>
        </div>

        <!-- Error Messages-->
        <ErrorMessage :errors="form.errors" />

        <form @submit.prevent="submit" class="space-y-2">
            <InputField label="Name" icon="id-badge" v-model="form.name" />

            <InputField label="Email" icon="at" v-model="form.email" />

            <InputField label="Password" type="password" icon="key" v-model="form.password" />

            <InputField label="Confirm Password" type="password" icon="key" v-model="form.password_confirmation" />

            <p class="text-slate-500 text-sm mt-6 mb-4 dark:text-slate-400">By creating an account, you agree to our Terms of Service and Privacy Policy</p>

            <PrimaryBtn :disabled="form.processing">Register</PrimaryBtn>
            <p class="text-center text-md mt-4">
                Already have an account?
                <TextLink routeName="login" label="Login" />
            </p>
        </form>
    </Container>
</template>