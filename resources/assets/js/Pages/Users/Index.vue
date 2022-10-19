<template>
  <div class="container mt-8">
    <form class="mb-8" @submit.prevent="search">
      <input class="form__group__control" type="text" placeholder="Search for users" v-model="searchQuery" />
    </form>
    <div class="mb-4 grid grid-cols-2 gap-4 lg:grid-cols-4">
      <user-card v-for="user of users.data" :key="user.id" :user="user" />
    </div>
    <div v-if="users.prev_page_url || users.next_page_url" class="flex justify-between">
      <button v-if="users.prev_page_url" class="button button--primary" type="button" @click.prevent="prevPage">
        Previous
      </button>
      <button v-if="users.next_page_url" class="button button--primary ml-auto" type="button" @click.prevent="nextPage">
        Next
      </button>
    </div>
  </div>
</template>

<script>
import UserCard from '@/Components/Users/UserCard'
// import Fuse from 'fuse.js'

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
      // pendingSearch: false,
      loading: false,
      searchQuery: '',
      // fuse: new Fuse([], { keys: ['name', 'username'], threshold: 0.2 })
    }
  },
  // watch: {
  //   users: {
  //     deep: true,
  //     immediate: true,
  //     handler(newVal) {
  //       if (!newVal) {
  //         return
  //       }
  //
  //       this.fuse.setCollection(newVal.data)
  //     }
  //   },
  //   searchQuery() {
  //     this.enqueueSearch()
  //   }
  // },
  // computed: {
  //   filteredUsersList() {
  //     if (!this.searchQuery) {
  //       return this.users.data
  //     }
  //
  //     return this.fuse.search(this.searchQuery).map(({ item }) => item)
  //   }
  // },
  methods: {
    // search() {
    //   const query = this.searchQuery?.length >= 3 ? this.searchQuery : undefined
    //
    //   this.$inertia.get(this.route('users.index'), { query }, { preserveScroll: true, preserveState: true })
    // },
    // enqueueSearch() {
    //   if (this.pendingSearch !== null) {
    //     clearTimeout(this.pendingSearch)
    //   }
    //
    //   this.pendingSearch = setTimeout(() => {
    //     this.pendingSearch = null
    //     this.search()
    //   }, 200)
    // },
    search() {
      this.$inertia.get(
        this.route('users.index'),
        { query: this.searchQuery },
        {
          preserveScroll: true,
          preserveState: true,
        }
      )
    },
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
