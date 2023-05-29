<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  title: "",
  message: "",
});

const submit = () => {
  form.post(route("post.store"), {
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <form @submit.prevent="submit" class="px-3 sm:px-6 lg:px-8">
    <div>
      <InputLabel
        for="title"
        value="Title"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
      />

      <TextInput
        id="title"
        type="text"
        class="mt-1 block w-full"
        v-model="form.title"
        required
        autofocus
        autocomplete="username"
      />

      <InputError class="mt-2" :message="form.errors.email" />
    </div>

    <label
      for="message"
      class="block my-2 text-sm font-medium text-gray-900 dark:text-white"
      >Your message</label
    >
    <textarea
      id="message"
      v-model="form.message"
      rows="5"
      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      placeholder="Leave a comment..."
    ></textarea>

    <div class="flex items-center justify-end mt-4">
      <PrimaryButton
        class="ml-4 mb-2"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Post
      </PrimaryButton>
    </div>
  </form>
</template>
