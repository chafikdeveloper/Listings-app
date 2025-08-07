<script setup>
  import { ref } from 'vue';

  const props = defineProps({
    listingImage: String | null,
  })
  const emit = defineEmits(['image']);

  const currentImage = props.listingImage ? `storage/${props.listingImage}` : null

  const preview = ref(currentImage);
  const oversizedImage = ref(false);

  const undoBtn = ref(false);

  const imageSelected = (e) => {
    preview.value = URL.createObjectURL(e.target.files[0]);
    oversizedImage.value = e.target.files[0].size > 3145728;
    emit('image', e.target.files[0]);
    undoBtn.value = true;
  }

  const revertImageChange = () => {
    undoBtn.value = false;
    preview.value = currentImage;
    oversizedImage.value = null;
    emit('image', null);
  }



</script>

<template>
  <div>
    <span class="block text-sm font-medium text-slate-700 dark:text-slate-300" :class="{'!text-red-500' : oversizedImage}">
      {{ oversizedImage ? "The selected image exceeds 3Mb" :  "Image (max size 3Mb)" }}
    </span>

    <label for="image" class="block rounded-md mt-1 bg-slate-300 h-[170px] overflow-hidden cursor-pointer border-slate-300 border relative" :class="{'!border-red-500' : oversizedImage}">
      <img :src="preview ?? '/storage/images/listing/default.png'" class="object-contain w-full h-full" alt="">

      <button type="button" v-if="undoBtn" @click.prevent="revertImageChange" class="absolute top-2 right-2 bg-white/75 w-8 h-8 rounded-full grid place-items-center text-slate-700">
        <i class="fa-solid fa-rotate-left"></i>
      </button>
    </label>

    <input @input="imageSelected" type="file" name="image" id="image" hidden>

  </div>
</template>