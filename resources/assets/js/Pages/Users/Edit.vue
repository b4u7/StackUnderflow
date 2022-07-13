<template>
  <section class="section mt-8">
    <div class="container mx-auto sm:max-w-lg flex flex-col sm:justify-center items-center">
      <tabs :tabs="tabs">
        <template #email>
          <edit-email-form :user="user" :errors="errors" :status="status" />
        </template>
        <template #password>
          <edit-password-form :user="user" :errors="errors" :status="status" />
        </template>
      </tabs>
    </div>
  </section>
</template>

<script>
import Tabs from '@/Components/Generic/Tabs'
import EditEmailForm from '@/Components/Users/EditEmailForm'
import EditPasswordForm from '@/Components/Users/EditPasswordForm'

export default {
  name: 'Edit',
  components: { EditPasswordForm, EditEmailForm, Tabs },
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
      tabs: [
        { name: 'Email', key: 'email' },
        { name: 'Password', key: 'password' },
      ],
    }
  },
}
</script>
