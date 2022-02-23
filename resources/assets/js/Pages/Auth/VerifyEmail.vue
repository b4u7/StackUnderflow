<template>
  <section>
    <div class="container mx-auto sm:max-w-lg min-h-screen flex flex-col sm:justify-center items-center">
      <Alert v-if="status && status === 'verification-link-sent'" kind="success" :fullwidth="true">
        <p>A fresh verification link has been sent to your email address.</p>
      </Alert>

      <h1 class="text-xl font-medium mb-4">Verify your email address</h1>

      <form class="form" @submit.prevent="submit">
        <div class="form__group">
          <p class="form__group__description">Before proceeding, please check your email for a verification link.</p>
        </div>
        <div class="form__footer">
          <button
            :class="{ 'button--processing': form.processing }"
            :disabled="form.processing"
            type="submit"
            class="button button--primary button--fullwidth mb-4"
          >
            Request another one
          </button>
          <p class="text-center">
            <a class="text-primary-600 underline" :href="route('home')"> Continue browsing questions </a>
          </p>
        </div>
      </form>
    </div>
  </section>
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
