<script setup>
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PostForm from "@/Components/Form/PostForm.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import PostList from "@/Components/Post/PostList.vue";
import EmptyBox from "@/Components/Icons/EmptyBox.vue";
import { ref, computed } from "vue";

const props = defineProps({
  posts: Object,
});

const isPosts = computed(() => (Object.keys(props.posts).length > 0 ? true : false));

const openCommentModal = ref(false);

const form = useForm({
  comment: "",
});

const openingModal = () => {
  openCommentModal.value = true;
};

const submit = () => {
  form.post(route("profile.destroy"), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  openCommentModal.value = false;

  form.reset();
};
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

          <PostForm />
        </div>
      </div>
    </div>

    <div class="py-2">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <template v-if="isPosts">
              <ol class="relative border-l border-gray-200 dark:border-gray-700">
                <PostList
                  @open-modal="openingModal"
                  v-for="(post, index) in props.posts"
                  :key="index"
                  :posts="post"
                />
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

    <Modal :show="openCommentModal" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
          Are you sure you want to delete your account?
        </h2>

        <p class="mt-1 text-sm text-gray-600">
          Once your account is deleted, all of its resources and data will be permanently
          deleted. Please enter your password to confirm you would like to permanently
          delete your account.
        </p>

        <div class="mt-6">
          <InputLabel for="comment" value="Comment" class="sr-only" />

          <TextInput
            id="comment"
            ref="commentInput"
            v-model="form.comment"
            type="text"
            class="mt-1 block w-3/4"
            placeholder="Enter a comment"
            @keyup.enter="submit"
          />

          <InputError :message="form.errors.comment" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
          <PrimaryButton
            class="ml-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="submit"
          >
            Delete Account
          </PrimaryButton>
        </div>
      </div>
    </Modal>
  </AuthenticatedLayout>
</template>
