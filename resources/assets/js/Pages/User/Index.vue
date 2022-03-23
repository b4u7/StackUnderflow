<template>
  <section class="section">
    <div class="container">
      <form class="form mb-4" @submit.prevent="search">
        <div class="form__group">
          <input
            type="text"
            name="search"
            class="form__group__control"
            v-model="form.user"
            placeholder="Search for users"
          />
        </div>
      </form>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <user-card
          v-for="user of users.data"
          :key="user.id"
          :user="user"
        />
      </div>
      <div v-if="this.users.prev_page_url || this.users.next_page_url" class="buttons flex justify-between">
        <button v-if="this.users.prev_page_url" class="button button--primary" type="button" @click.prevent="prevPage">
          Previous
        </button>
        <button
          v-if="this.users.next_page_url"
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
      required: true
    }
  },
  data() {
    return {
      loading: false,
      form: {
        user: null
      }
    }
  },
  methods: {
    search() {
    },
    prevPage() {
      if (!this.users.prev_page_url || this.loading) {
        return
      }

      this.loading = true

      this.$inertia.visit(this.users.prev_page_url, {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => (this.loading = false)
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
        onFinish: () => (this.loading = false)
      })
    }
  }
}
</script>
