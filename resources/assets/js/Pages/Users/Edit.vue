<template>
  <section class="section mt-8">
    <div class="container">
      <form class="form" @submit.prevent="submit">
        <div class="md:max-w-2xl flex flex-col items-center">
          <h1 class="text-xl font-medium my-4">Account settings</h1>
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
            <label for="password" class="form__group__label"> Current password </label>
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
          <div class="form__group">
            <label for="password" class="form__group__label"> New password </label>
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
          <div class="form__group">
            <label for="password" class="form__group__label"> Confirm new password </label>
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
        </div>
      </form>
    </div>
  </section>
</template>

<script>
// https://appdividend.com/2018/06/02/laravel-avatar-image-upload-tutorial-with-example/
// https://flowbite.com/docs/components/forms/
import Tabs from '@/Components/Generic/Tabs'
import Modal from '@/Components/Generic/Modal'

export default {
  name: 'Edit',
  components: { Modal, Tabs },
  props: {
    user: {
      type: Object,
      required: true,
    },
    errors: {
      type: Object,
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        email: this.user.email,
        current_password: '',
        new_password: '',
        confirm_new_password: '',
      }),
    }
  },
  methods: {
    submit() {
      this.form
        .transform(data => ({
          ...data,
        }))
        .post(this.route('user-profile-information.update'), {
          onFinish: () => this.form.reset('current_password', 'new_password', 'confirm_new_password'),
        })
    },
  },
}
</script>
