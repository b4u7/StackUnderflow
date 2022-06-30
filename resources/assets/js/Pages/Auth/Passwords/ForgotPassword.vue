<template>
  <section>
    <div class="container mx-auto sm:max-w-lg min-h-screen flex flex-col sm:justify-center items-center">
      <alert v-if="status" class="mb-8" kind="success" :fullwidth="true">
        {{ status }}
      </alert>
      <h1 class="text-xl font-medium mb-4">Forgot your password?</h1>
      <form class="form" @submit.prevent="submit">
        <div class="form__group">
          <label for="email-address" class="form__group__label">Email address</label>
          <input
            type="email"
            name="email-address"
            id="email-address"
            class="form__group__control"
            v-model="form.email"
            autocomplete="email"
            required
            autofocus
          />
          <p
            v-if="errors.email"
            class="form__group__description form__group__description--error"
            v-text="errors.email"
          />
        </div>
        <div class="form__footer">
          <button class="button button--primary button--fullwidth mb-4" type="submit" :disabled="form.processing">
            Email password reset link
          </button>
          <p class="text-center">
            Don't have an account?
            <a class="text-primary-600 underline" :href="route('register')"> Create one here </a>
          </p>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import Alert from '@/Components/Alert'

export default {
  name: 'ForgotPassword',
  components: { Alert },
  props: {
    errors: {
      type: Object,
      required: false,
    },
    status: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        email: '',
      }),
    }
  },
  methods: {
    submit() {
      this.form
        .transform(data => ({
          ...data,
        }))
        .post(this.route('password.email'))
    },
  },
}
</script>
