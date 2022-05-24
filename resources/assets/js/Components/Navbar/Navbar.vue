<template>
  <nav :class="`navbar--${dark ? 'dark' : 'primary'}`" class="navbar">
    <ul class="navbar__start">
      <li class="navbar__item">
        <a class="navbar__logo" :href="route('home')"> StackUnderflow </a>
      </li>
    </ul>
    <ul class="navbar__center">
      <li class="navbar__item">
        <form @submit.prevent="search">
          <input
            :class="{ 'navbar__search--dark': dark }"
            class="navbar__search"
            type="text"
            placeholder="Search questions"
            spellcheck="false"
            autocomplete="off"
            v-model="searchQuery"
          />
        </form>
      </li>
    </ul>
    <ul class="navbar__end">
      <template v-if="user">
        <inbox />
        <li class="relative navbar__item" ref="dropdown" @click="toggleDropdown">
          <button type="button" class="navbar__user">
            <img :src="user.avatar" alt="Your user avatar" />
          </button>
          <transition name="dropdown-transition">
            <div v-if="dropdownMenuVisible" class="navbar__dropdown">
              <div class="navbar__dropdown__container">
                <Link :href="route('users.show', user)" class="navbar__dropdown__item">Profile</Link>
                <Link :href="route('users.bookmarks.index', user)" class="navbar__dropdown__item">My bookmarks</Link>
                <Link :href="route('users.edit', user)" class="navbar__dropdown__item">Account settings</Link>
                <Link as="button" class="navbar__dropdown__item" @click.prevent="logout">Logout</Link>
              </div>
            </div>
          </transition>
        </li>
      </template>
      <template v-else>
        <li class="navbar__item">
          <a :href="route('login')" class="button button--primary"> Login </a>
        </li>
        <li class="navbar__item">
          <a :href="route('register')" class="button button--white"> Register </a>
        </li>
      </template>
    </ul>
  </nav>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import Inbox from '@/Components/Navbar/Inbox'
import Tippy from '@/Components/Tippy'

export default {
  name: 'Navbar',
  components: { Link, Tippy, Inbox },
  props: {
    dark: {
      type: Boolean
    }
  },
  data() {
    return {
      dropdownMenuVisible: false,
      pendingSearch: null,
      searchQuery: ''
    }
  },
  mounted() {
    if (!this.$refs.dropdown) {
      return
    }

    document.addEventListener('click', this.onDocumentClick)
  },
  beforeDestroy() {
    if (!this.$refs.dropdown) {
      return
    }

    document.removeEventListener('click', this.onDocumentClick)
  },
  // watch: {
  //   searchQuery(newVal) {
  //     if (newVal.length < 3) {
  //       if (this.pendingSearch !== null) {
  //         clearTimeout(this.pendingSearch)
  //         this.pendingSearch = null
  //       }
  //
  //       return
  //     }
  //
  //     if (this.pendingSearch !== null) {
  //       clearTimeout(this.pendingSearch)
  //     }
  //
  //     this.pendingSearch = setTimeout(() => {
  //       this.pendingSearch = null
  //       this.search()
  //     }, 200)
  //   }
  // },
  computed: {
    user() {
      return this.$page.props.auth.user ?? null
    }
  },
  methods: {
    onDocumentClick(e) {
      if (!this.$refs.dropdown) {
        return
      }

      if (!this.$refs.dropdown.contains(e.target)) {
        this.dropdownMenuVisible = false
      }
    },
    toggleDropdown() {
      this.dropdownMenuVisible = !this.dropdownMenuVisible
    },
    logout() {
      this.$inertia.post(this.route('logout'))
    },
    search() {
      this.$inertia.get(
        this.route(
          'questions.index',
          { query: this.searchQuery },
          {
            preserveScroll: true,
            preserveState: true
          }
        )
      )
    }
  }
}
</script>
