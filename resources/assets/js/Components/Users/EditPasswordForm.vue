<template>
  <form class="form" @submit.prevent="submit">
    <h1 class="mt-8 mb-4 text-xl font-medium">Change password</h1>
    <alert class="my-8" v-if="status && status === 'password-updated'" kind="success" fullwidth>
      <p>Your password was successfully updated.</p>
    </alert>
    <div :class="{ 'form__group--error': errors.current_password }" class="form__group">
      <label for="current-password" class="form__group__label"> Current password </label>
      <input
        id="current-password"
        class="form__group__control"
        type="password"
        v-model="form.current_password"
        autocomplete="password"
        required
      />
      <p v-if="errors.curent_password" class="form__group__description">
        <font-awesome-icon icon="fa-solid fa-circle-exclamation" />
        {{ errors.current_password }}
      </p>
      <!-- FIXME: Temporarily remove this
      <p class="form__group__description">
        Forgot your password? Click
        <a class="text-primary-600 underline" :href="route('password.request')">here</a>
        to reset it
      </p>
       -->
    </div>
    <div :class="{ 'form__group--error': errors.password }" class="form__group">
      <label for="password" class="form__group__label"> New password </label>
      <input
        id="password"
        class="form__group__control"
        type="password"
        v-model="form.password"
        autocomplete="new-password"
        required
      />
      <p v-if="!errors.password" class="form__group__description">Enter the new password</p>
      <p v-else class="form__group__description">
        <font-awesome-icon icon="fa-solid fa-circle-exclamation" />
        {{ errors.password }}
      </p>
    </div>
    <div :class="{ 'form__group--error': errors.password_confirmation }" class="form__group">
      <label for="password-confirmation" class="form__group__label"> Confirm new password </label>
      <input
        id="password-confirmation"
        class="form__group__control"
        type="password"
        v-model="form.password_confirmation"
        autocomplete="new-password"
        required
      />
      <p v-if="!errors.password_confirmation" class="form__group__description">Confirm your new password</p>
      <p v-else class="form__group__description">
        <font-awesome-icon icon="fa-solid fa-circle-exclamation" />
        {{ errors.password_confirmation }}
      </p>
    </div>
    <div class="form__footer">
      <button class="button button--primary button--fullwidth mb-4" type="submit" :disabled="form.processing">
        Change password
      </button>
      <p class="text-center">You will be logged out from all other devices</p>
    </div>
  </form>
</template>

<script>
import Alert from '@/Components/Alert'

export default {
  name: 'EditPasswordForm',
  components: { Alert },
  props: {
    user: {
      type: Object,
      required: true,
    },
    errors: {
      type: Object,
    },
    status: {
      type: String,
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        current_password: '',
        password: '',
        password_confirmation: '',
      }),
    }
  },
  methods: {
    submit() {
      this.form.put(this.route('user-password.update'), {
        onFinish: () => this.form.reset('current_password', 'password', 'password_confirmation'),
      })
    },
    sendResetPasswordLink() {
      this.$inertia.post(this.route('password.email', [this.user.email]))
    },
  },
}
</script>
