<template>
  <section>
    <div class="container mx-auto sm:max-w-md min-h-screen flex flex-col sm:justify-center items-center">
      <h1 class="text-xl font-medium mb-4">Register</h1>

      <form class="form" @submit.prevent="submit">
        <div class="form__group">
          <label for="name" class="form__group__label">Name</label>
          <input
            type="text"
            name="name"
            id="name"
            autocomplete="name"
            class="form__group__control"
            v-model="form.name"
            required
          />
        </div>
        <div class="form__group">
          <label for="email-address" class="form__group__label">Email address</label>
          <input
            type="email"
            name="email-address"
            id="email-address"
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
            autocomplete="new-password"
            required
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
        </div>
        <div class="form__footer">
          <div class="form__group">
            <a class="form__group__description underline" :href="route('login')">Already registered?</a>
            <button type="submit" class="button button--primary ml-4" :disabled="form.processing">Register</button>
          </div>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
export default {
  name: 'Register',
  props: {
    status: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        name: '',
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
        .post(this.route('register'), {
          onFinish: () => this.form.reset('password', 'password_confirmation'),
        })
    },
  },
}
</script>

<style scoped></style>
