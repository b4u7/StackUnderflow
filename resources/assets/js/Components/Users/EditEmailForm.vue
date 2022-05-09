<template>
  <form class="form" @submit.prevent="submit">
    <div class="md:max-w-2xl flex flex-col items-center">
      <h1 class="text-xl font-medium my-4">Account settings</h1>
      <div :class="{ 'form__group--error': errors.current_password }" class="form__group">
        <label for="password" class="form__group__label"> Current password </label>
        <input
          type="password"
          name="password"
          id="password"
          class="form__group__control"
          v-model="form.current_password"
          autocomplete="current-password"
          required
        />
        <p v-if="!errors.current_password" class="form__group__description">Your email address</p>
        <p v-else class="form__group__description">
          <font-awesome-icon icon="fa-solid fa-circle-exclamation" />
          {{ errors.current_password }}
        </p>
      </div>
      <div class="form__footer">
        <button class="button button--primary button--fullwidth mb-4" type="submit" :disabled="form.processing">
          Change email
        </button>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  name: 'EditEmailForm',
  data() {
    return {
      form: this.$inertia.form({
        current_password: '',
        new_password: '',
        confirm_new_password: '',
      }),
    }
  },
  methods: {
    submit() {
      this.form.post(this.route('user-profile-information.update'), {
        onFinish: () => this.form.reset('current_password', 'new_password', 'confirm_new_password'),
      })
    },
  },
}
</script>
