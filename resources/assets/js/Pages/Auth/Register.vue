<template>
  <div class="container mx-auto mt-8 flex min-h-screen flex-col items-center sm:max-w-lg sm:justify-center">
    <h1 class="mb-4 text-xl font-medium">Register an account</h1>
    <p>Join the Stack Underflow community to collaborate and share knowledge without any limitations.</p>
    <form class="form mt-4" @submit.prevent="submit">
      <div class="form__group">
        <label for="name" class="form__group__label">Name</label>
        <input
          id="name"
          class="form__group__control"
          type="text"
          autocomplete="name"
          v-model="form.name"
          required
          autofocus
        />
        <p v-if="errors.name" class="form__group__description form__group__description--error" v-text="errors.name" />
      </div>
      <div class="form__group">
        <label for="username" class="form__group__label">Username</label>
        <input
          id="username"
          class="form__group__control"
          type="text"
          autocomplete="username"
          v-model="form.username"
          required
        />
        <p
          v-if="errors.username"
          class="form__group__description form__group__description--error"
          v-text="errors.username"
        />
      </div>
      <div class="form__group">
        <label for="email-address" class="form__group__label">Email address</label>
        <input id="email-address" class="form__group__control" type="email" v-model="form.email" required />
        <p v-if="errors.email" class="form__group__description form__group__description--error" v-text="errors.email" />
      </div>
      <div class="form__group">
        <label for="password" class="form__group__label">Password</label>
        <input
          id="password"
          class="form__group__control"
          type="password"
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
          class="form__group__control"
          type="password"
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
        <button class="button button--primary button--fullwidth mb-4" type="submit" :disabled="form.processing">
          Register
        </button>
        <p class="text-center">
          Already have an account?
          <a class="text-primary-600 underline" :href="route('login')"> Login here </a>
        </p>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'RegisterPage',
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
        name: '',
        username: '',
        email: '',
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
        .post(this.route('register'))
    },
  },
}
</script>
