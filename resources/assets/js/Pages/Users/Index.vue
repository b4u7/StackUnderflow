<template>
  <section class="section mt-8">
    <div class="container">
      <form class="mb-8" @submit.prevent="search">
        <input
          class="form__group__control"
          type="text"
          placeholder="Search for users"
          v-model="form.user"
        />
      </form>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <user-card v-for="user of users.data" :key="user.id" :user="user" />
      </div>
      <div v-if="users.prev_page_url || users.next_page_url" class="flex justify-between">
        <button v-if="users.prev_page_url" class="button button--primary" type="button" @click.prevent="prevPage">
          Previous
        </button>
        <button
          v-if="users.next_page_url"
          class="ml-auto button button--primary"
          type="button"
          @click.prevent="nextPage"
        >
          Next
        </button>
      </div>
    </div>
  </section>
</template>

<script>
import UserCard from '@/Components/Users/UserCard'

export default {
  name: 'Index',
  components: { UserCard },
  props: {
    users: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      loading: false,
      form: {
        user: null,
      },
    }
  },
  methods: {
    search() {},
    prevPage() {
      if (!this.users.prev_page_url || this.loading) {
        return
      }

      this.loading = true

      this.$inertia.visit(this.users.prev_page_url, {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => (this.loading = false),
      })
    },
    nextPage() {
      if (!this.users.next_page_url || this.loading) {
        return
      }

      this.loading = true

      this.$inertia.visit(this.users.next_page_url, {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => (this.loading = false),
      })
    },
  },
}
</script>
