<script setup>
import Container from '../../../components/Container.vue';
import Title from '../../../components/Title.vue';
import InputField from '../../../components/InputField.vue';
import PrimaryBtn from '../../../components/PrimaryBtn.vue';
import SessionMessage from '../../../components/SessionMessage.vue';
import ErrorMessage from '../../../components/ErrorMessage.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  currentPassword: "",
  newPassword: "",
  newPassword_confirmation: ""
})

const submit = () => {
  form.put(route("profile.password"), {
    preserveScroll: true,
    onError: () => form.reset(),
    onSuccess: () => form.reset(),
  });
}
</script>

<template>
  <Container class="mb-6">
    <div class="mb-6">
      <Title>Update Password</Title>
      <p>Ensure you are using a long, random password to stay secure.</p>
    </div>

    <ErrorMessage :errors="form.errors" />

    <form @submit.prevent="submit" class="space-y-6">
      <InputField label="Current Password" icon="key" type="password"  class="w-1/2" v-model="form.currentPassword"/>

      <InputField label="New Password" icon="key" type="password"  class="w-1/2" v-model="form.newPassword"/>

      <InputField label="Confirm New Password" icon="key" type="password"  class="w-1/2" v-model="form.newPassword_confirmation"/>

      <SessionMessage :message="status" />

      <p v-if="form.recentlySuccessful" class="text-md text-green-600">New password saved successfully</p>
      <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
    </form>
  </Container>
</template>