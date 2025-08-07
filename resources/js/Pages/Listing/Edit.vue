<script setup>
import Container from '../../components/Container.vue';
import Title from '../../components/Title.vue';
import InputField from '../../components/InputField.vue';
import TextArea from '../../components/TextArea.vue';
import ImageUpload from '../../components/ImageUpload.vue';
import ErrorMessage from '../../components/ErrorMessage.vue';
import PrimaryBtn from '../../components/PrimaryBtn.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    listing: Object,
})

const form = useForm({
  title: props.listing.title,
  desc: props.listing.desc,
  tags: props.listing.tags,
  link: props.listing.link,
  email: props.listing.email,
  image: null,
  _method: 'PUT',
})

const submit = () => {
  form.post(route('listing.update', props.listing.id));
}
</script>

<template>
  <Head title="Edit Listing" />

  <Container>
    <div class="mb-6">
      <Title>Edit your listing</Title>
    </div>

    <ErrorMessage :errors="form.errors" />

    <form @submit.prevent="submit" class="grid grid-cols-2 gap-6">
      <div class="space-y-6">
        <InputField label="Title" icon="heading" placeholder="My new listing" v-model="form.title" />

        <InputField label="Tags (seperated with comma)" icon="tags" placeholder="one, two" v-model="form.tags" />

        <TextArea label="Description" icon="newspaper" placeholder="My new listing description" v-model="form.desc"></TextArea>
      </div>

      <div class="space-y-6">
        <InputField label="Email" icon="at" placeholder="example@email.com" v-model="form.email" />

        <InputField label="External Link" icon="up-right-from-square" placeholder="https://example.com" v-model="form.link" />

        <ImageUpload @image="(e) => form.image = e" :listingImage="listing.image" />

      </div>

      <div>
        <PrimaryBtn :disabled="form.processing">Update</PrimaryBtn>
      </div>
    </form>
  </Container>
</template>