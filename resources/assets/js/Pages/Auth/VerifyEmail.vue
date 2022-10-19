<template>
  <div class="container mx-auto mt-8 flex min-h-screen flex-col items-center sm:max-w-lg sm:justify-center">
    <alert v-if="status && status === 'verification-link-sent'" class="mb-8" kind="success" fullwidth>
      <p>A fresh verification link has been sent to your email address.</p>
    </alert>
    <h1 class="mb-4 text-xl font-medium">Verify your email address</h1>
    <form class="form" @submit.prevent="submit">
      <div class="form__group">
        <p class="form__group__description">Before proceeding, please check your email for a verification link.</p>
      </div>
      <div class="form__footer">
        <button class="button button--primary button--fullwidth mb-4" type="submit" :disabled="form.processing">
          Request another one
        </button>
        <p class="text-center">
          <a class="text-primary-600 underline" :href="route('home')"> Continue browsing questions </a>
        </p>
      </div>
    </form>
  </div>
</template>

<script>
import Alert from '@/Components/Alert'

export default {
  name: 'VerifyEmail',
  components: { Alert },
  props: {
    status: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      form: this.$inertia.form({}),
    }
  },
  methods: {
    submit() {
      this.form.post(this.route('verification.send'))
    },
  },
}
</script>
