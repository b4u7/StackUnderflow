<template>
  <div class="container mx-auto mt-8 flex min-h-screen flex-col items-center sm:max-w-lg sm:justify-center">
    <h1 class="mb-4 text-xl font-medium">Login</h1>
    <form class="form" @submit.prevent="submit">
      <div class="form__group">
        <label for="username" class="form__group__label"> Username </label>
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
        <label for="password" class="form__group__label">Password</label>
        <input
          id="password"
          class="form__group__control"
          type="password"
          autocomplete="current-password"
          v-model="form.password"
          required
        />
        <p
          v-if="errors.password"
          class="form__group__description form__group__description--error"
          v-text="errors.email"
        />
      </div>
      <div class="grid grid-cols-2">
        <div class="form__checkbox">
          <div class="flex h-6 items-center">
            <input id="remember" class="form__checkbox__control" type="checkbox" v-model:checked="form.remember" />
          </div>
          <label for="remember" class="form__checkbox__label">Remember me</label>
        </div>
        <p class="form__group__description text-right">
          <a v-if="canResetPassword" :href="route('password.request')" class="underline"> Forgot your password? </a>
        </p>
      </div>
      <div class="form__footer">
        <button class="button button--primary button--fullwidth mb-4" type="submit" :disabled="form.processing">
          Let me in
        </button>
        <p class="text-center">
          Don't have an account?
          <a class="text-primary-600 underline" :href="route('register')"> Create one here </a>
        </p>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'Login',
  props: {
    errors: {
      type: Object,
    },
    canResetPassword: {
      type: Boolean,
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
        username: '',
        password: '',
        remember: false,
      }),
    }
  },
  methods: {
    submit() {
      this.form
        .transform(data => ({
          ...data,
          remember: this.form.remember ? 'on' : '',
        }))
        .post(this.route('login'), {
          onFinish: () => this.form.reset('password'),
        })
    },
  },
}
</script>
