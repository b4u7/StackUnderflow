<template>
  <form class="form" @submit.prevent="submit">
    <h1 class="text-xl font-medium mt-8 mb-4">Change email address</h1>
    <alert class="my-8" v-if="status && status === 'profile-information-updated'" kind="success" fullwidth>
      <p>A fresh verification link has been sent to your email address.</p>
    </alert>
    <div :class="{ 'form__group--error': errors.email }" class="form__group">
      <label for="email-address" class="form__group__label"> Email address </label>
      <input
        id="email-address"
        :class="{ disabled: editing }"
        class="form__group__control"
        type="email"
        autocomplete="email"
        v-model="form.email"
        :disabled="!editing"
      />
      <p v-if="!editing" class="form__group__description">Your current email address</p>
      <p v-else class="form__group__description">Your new email address</p>
      <p v-if="errors.email" class="form__group__description" v-text="errors.email" />
    </div>
    <div class="form__footer">
      <template v-if="!editing">
        <button class="button button--primary button--fullwidth mb-4" type="submit" :disabled="form.processing">
          Change email
        </button>
        <p class="text-center">Press the button to enable editing.</p>
      </template>
      <template v-else>
        <button
          v-if="emailChanged"
          class="button button--primary button--fullwidth mb-4"
          type="submit"
          :disabled="form.processing"
        >
          Save new email address
        </button>
        <button
          v-else
          class="button button--secondary button--fullwidth mb-4"
          type="submit"
          :disabled="form.processing"
        >
          Cancel
        </button>
        <p class="text-center">Make sure to enter a valid email, we will send you a confirmation request.</p>
      </template>
    </div>
  </form>
</template>

<script>
import Alert from '@/Components/Alert'

export default {
  name: 'EditEmailForm',
  components: { Alert },
  props: {
    user: {
      type: Object,
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
      editing: false,
      form: this.$inertia.form({
        name: this.user.name,
        email: this.user.email,
      }),
    }
  },
  methods: {
    async submit() {
      if (this.editing && this.emailChanged) {
        await this.form.put(this.route('user-profile-information.update'))
      }

      this.editing = !this.editing
    },
  },
  computed: {
    emailChanged() {
      return this.form.email !== this.user.email
    },
  },
}
</script>
