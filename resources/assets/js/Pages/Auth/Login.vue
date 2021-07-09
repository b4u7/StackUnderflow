<!-- TODO: Show errors -->
<template>
  <section>
    <div class="container mx-auto sm:max-w-md min-h-screen flex flex-col sm:justify-center items-center">
      <h1 class="text-xl font-medium mb-4">Login</h1>

      <form class="form" @submit.prevent="submit">
        <div class="form__group">
          <label for="email-address" class="form__group__label">Email address</label>
          <input
            type="email"
            name="email-address"
            id="email-address"
            autocomplete="email"
            class="form__group__control"
            v-model="form.email"
            required
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
            autocomplete="current-password"
            required
          />
        </div>
        <div class="form__checkbox">
          <div class="flex items-center h-6">
            <input
              id="remember"
              name="remember"
              type="checkbox"
              class="form__checkbox__control"
              v-model:checked="form.remember"
            />
          </div>
          <label for="remember" class="form__checkbox__label">Remember me</label>
        </div>

        <div class="form__footer">
          <div class="form__group mt-4">
            <a v-if="canResetPassword" class="form__group__description underline" :href="route('password.request')">
              Forgot your password?
            </a>
            <button type="submit" class="button button--primary ml-4" :disabled="form.processing">Login</button>
          </div>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
export default {
  name: 'Login',
  props: {
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
        email: '',
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

<style scoped></style>
