<template>
  <section>
    <div class="container mx-auto sm:max-w-lg min-h-screen flex flex-col sm:justify-center items-center">
      <h1 class="text-xl font-medium mb-4">Reset your password</h1>

      <form class="form" @submit.prevent="submit">
        <input type="hidden" name="token" :value="token" />

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
        <div class="form__group">
          <label for="password" class="form__group__label">Password</label>
          <input
            type="password"
            name="password"
            id="password"
            class="form__group__control"
            v-model="form.password"
            autocomplete="new-password"
            required
          />
          <p
            v-if="errors.password"
            class="form__group__description form__group__description--error"
            v-text="errors.password"
          />
        </div>
        <div class="form__group">
          <label for="password-confirm" class="form__group__label">Confirm password</label>
          <input
            id="password-confirm"
            type="password"
            class="form__group__control"
            name="password_confirmation"
            v-model="form.password_confirmation"
            autocomplete="new-password"
            required
          />
          <p
            v-if="errors.password_confirmation"
            class="form__group__description form__group__description--error"
            v-text="errors.password_confirmation"
          />
        </div>
        <div class="form__footer">
          <button
            :class="{ 'button--processing': form.processing }"
            :disabled="form.processing"
            type="submit"
            class="button button--primary button--fullwidth mb-4"
          >
            Reset password
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
  name: 'Reset',
  components: { Alert },
  props: {
    token: {
      type: String,
      required: true,
    },
    errors: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        token: this.token,
        email: this.email,
        password: '',
        password_confirmation: '',
      }),
    }
  },
  methods: {
    submit() {
      this.form
        .transform(data => ({
          ...data,
        }))
        .post(this.route('password.update'), {
          onFinish: () => this.form.reset('password', 'password_confirmation'),
        })
    },
  },
}
</script>
