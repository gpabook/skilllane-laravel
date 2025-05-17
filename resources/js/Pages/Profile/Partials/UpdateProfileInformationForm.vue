<script setup>
import { ref } from 'vue'                                        // 1️⃣
import { Link, useForm, usePage } from '@inertiajs/vue3'
import InputError  from '@/Components/InputError.vue'
import InputLabel  from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput   from '@/Components/TextInput.vue'

defineProps({
  mustVerifyEmail: Boolean,
  status:           String,
})

/** Grab the user object from Inertia’s shared props **/
//const user = usePage().props.auth?.user ?? usePage().props.user
const user = usePage().props.user


/** Build the form (Inertia auto-detects file uploads) **/

const form = useForm({
  name:   user.name,
  email:  user.email,
  avatar: null,
})

/** Local preview URL for the avatar **/
const preview = ref(user.avatar_url)
/** File input change handler **/
function onFileChange(e) {
  const file = e.target.files[0]
  if(file) {
  form.avatar = file
  preview.value = URL.createObjectURL(file)
  } else {
    form.avatar = null;
    preview.value = user.avatar_url;
}
}
/** Submit helper (if you prefer not to inline patch in template) **/
function submitava() {
  form.patch(route('profile.update'), {
    preserveScroll: true,
   // headers: { 'Content-Type': 'multipart/form-data' },
    onSuccess: () => {
        console.log('Profile updated successfully with PATCH!');
    },
    onError: (errors) => {
        console.error('Form submission error with PATCH:', errors);
        if (errors.avatar) {
            // This will show you backend validation errors for the avatar
        console.error('Avatar specific error:', errors.avatar);
        alert(`Avatar error: ${errors.avatar}`);

        }
    }
  });
}
</script>

<template>
  <section>
    <header>
      <h2>Profile Information</h2>
      <p>Update your account’s profile info and email address.</p>
    </header>

    <!-- Either call `submit` or patch inline. Here’s using `submit`. -->
    <form @submit.prevent="submitava" enctype="multipart/form-data" class="mt-6 space-y-6">
      <!-- Avatar -->
      <div>
        <InputLabel for="avatarInput" value="Avatar" />        <!-- 2️⃣ -->
        <input
          id="avatarInput"
          ref="avatarInput"
          type="file"
          accept="image/*"
          @change="onFileChange"
          class="block mt-1"
        />
        <div v-if="preview" class="mt-2">
          <img :src="preview" class="w-24 h-24 rounded-full" />
        </div>
      </div>

      <!-- Name -->
      <div>
        <InputLabel for="name" value="Name" />
        <TextInput
         ref="name"
         v-model="form.name"
          id="name"
          type="text"
          class="block w-full mt-1"
          required
          autofocus
          autocomplete="name"
        />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <!-- Email -->
      <div>
        <InputLabel for="email" value="Email" />
        <TextInput
          ref="email"
          id="email"
          type="email"
          v-model="form.email"
          class="block w-full mt-1"
          required
          autocomplete="username"
        />
        <InputError :message="form.errors.email" class="mt-2" />
      </div>

      <!-- Email verification notice -->
      <div v-if="mustVerifyEmail && !user.email_verified_at">
        <p>Your email is unverified.
          <Link
            :href="route('verification.send')"
            method="post"
            as="button"
            class="underline"
          >
            Click to resend verification email.
          </Link>
        </p>
        <p v-if="status === 'verification-link-sent'" class="text-green-600">
          A new verification link has been sent.
        </p>
      </div>

      <!-- Actions -->
      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
      </div>
    </form>
  </section>
</template>
