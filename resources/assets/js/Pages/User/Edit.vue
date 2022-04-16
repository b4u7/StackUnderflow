<template>
  <section class="section mt-8">
    <div class="container">
      <tabs :tabs="tabs">
        <template #account>
          <div class="md:max-w-2xl flex flex-col items-center">
            <h1 class="text-xl font-medium my-4">Account settings</h1>
            <form class="form" @submit.prevent="submit">
              <div class="form__group">
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
                  autocomplete="current-password"
                  required
                />
                <p
                  v-if="errors.password"
                  class="form__group__description form__group__description--error"
                  v-text="errors.email"
                />
              </div>
              <div class="form__footer">
                <button class="button button--primary button--fullwidth mb-4" type="submit" :disabled="form.processing">
                  Save
                </button>
              </div>
            </form>
          </div>
        </template>
        <template #profile> </template>
      </tabs>
    </div>
  </section>
</template>

<script>
import Tabs from '@/Components/Generic/Tabs'

export default {
  name: 'Edit',
  components: { Tabs },
  props: {
    errors: {
      type: Object,
    },
  },
  data() {
    return {
      tabs: [
        { name: 'Account', key: 'account' },
        { name: 'Profile', key: 'profile' },
      ],
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
