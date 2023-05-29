<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, useForm } from "@inertiajs/vue3";
import PostList from "@/Components/Post/PostList.vue";
import EmptyBox from "@/Components/Icons/EmptyBox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { computed, onMounted, ref } from "vue";

const props = defineProps({
  posts: Object,
});

onMounted(() => {
  list.value = props.posts;
});

const list = ref([]);

const form = useForm({
  title: "",
  message: "",
});

const submit = () => {
  list.value.push(form.message);

  form.post(route("post.store"), {
    onFinish: () => form.reset("password"),
  });
};

const isPosts = computed(() => (list.value.length > 0 ? true : false));
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="px-6 py-4 text-2xl text-center underline text-gray-900">
            Create a post
          </div>

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
        </div>
      </div>
    </div>

    <div class="py-2">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <template v-if="isPosts">
              <ol class="relative border-l border-gray-200 dark:border-gray-700">
                <PostList />
              </ol>
            </template>

            <template v-else>
              <div class="grid place-content-center">
                <EmptyBox />

                <span>No Posts</span>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
