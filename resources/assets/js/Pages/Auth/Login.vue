<template>
  <section>
    <div class="container mx-auto sm:max-w-lg min-h-screen flex flex-col sm:justify-center items-center">
      <h1 class="text-xl font-medium mb-4">Login</h1>

      <form class="form" @submit.prevent="submit">
        <!--        <div class="form__group">
                  <label for="email-address" class="form__group__label"> Email address </label>
                  <input
                    type="email"
                    name="email-address"
                    id="email-address"
                    autocomplete="email"
                    class="form__group__control"
                    v-model="form.email"
                    required
                  />
                  <p
                    v-if="errors.email"
                    class="form__group__description form__group__description&#45;&#45;error"
                    v-text="errors.email"
                  />
                </div>-->
        <div class="form__group">
          <label for="username" class="form__group__label"> Username </label>
          <input
            id="username"
            class="form__group__control"
            type="text"
            name="username"
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
            type="password"
            name="password"
            id="password"
            class="form__group__control"
            v-model="form.password"
            autocomplete="current-password"
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
  </section>
</template>

<script>
export default {
  name: 'Login',
  props: {
    errors: {
      type: Object,
      required: false,
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
