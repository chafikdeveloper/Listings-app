<script setup>
import { useForm } from '@inertiajs/vue3';
import Container from '../../components/Container.vue';
import InputField from '../../components/InputField.vue';
import PrimaryBtn from '../../components/PrimaryBtn.vue';
import ErrorMessage from '../../components/ErrorMessage.vue';

const props = defineProps({
  token: String,
  email: String
})

const form = useForm({
  email: props.email,
  password: "",
  password_confirmation: "",
  token: props.token,
});

const submit = () => {
  form.post(route('password.update'), {
    onFinish: () => form.reset('password', 'password_confirmation')
  });
}
</script>

<template>
  <Head title="Reset Password" />
  <Container class="w-1/2">

    <ErrorMessage :errors="form.errors" />

    <InputField label="Email" icon="at" v-model="form.email" />

    <InputField label="Password" icon="key" type="password" v-model="form.password" />

    <InputField label="Confirm Password" icon="key" type="password" v-model="form.password_confirmation" />

    <form @submit.prevent="submit">
      <PrimaryBtn :disabled="form.processing">Reset Password</PrimaryBtn>
    </form>
  </Container>
</template>