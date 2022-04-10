<template>
  <nav class="navbar navbar--primary">
    <ul class="navbar__start">
      <li class="navbar__item">
        <a class="navbar__logo" :href="route('home')"> StackUnderflow </a>
      </li>
    </ul>
    <ul class="navbar__center">
      <li class="navbar__item">
        <form @submit.prevent="search">
          <input class="navbar__search" type="text" name="search" placeholder="Search..." autocomplete="off" />
        </form>
      </li>
    </ul>
    <ul class="navbar__end">
      <template v-if="user">
        <inbox />
        <li class="relative navbar__item" ref="dropdown" @click="toggleDropdown">
          <button type="button">
            <img :src="user.avatar" class="navbar__user" alt="Your user avatar" />
          </button>
          <transition name="dropdown-transition">
            <div v-if="dropdownMenuVisible" class="navbar__dropdown">
              <div class="navbar__dropdown__container">
                <a :href="route('user.show', user)" class="navbar__dropdown__item"> Profile </a>
                <a :href="route('user.edit', user)" class="navbar__dropdown__item"> Edit profile </a>
                <form class="navbar__dropdown__item" @submit.prevent="logout">
                  <button type="submit">Logout</button>
                </form>
              </div>
            </div>
          </transition>
        </li>
      </template>
      <template v-else>
        <li class="navbar__item">
          <a :href="route('login')" class="button button--primary-lighter"> Login </a>
        </li>
        <li class="navbar__item">
          <a :href="route('register')" class="button button--light"> Register </a>
        </li>
      </template>
    </ul>
  </nav>
</template>

<script>
import Inbox from '@/Components/Navbar/Inbox'
import Tippy from '@/Components/Tippy'

export default {
  name: 'Navbar',
  components: { Tippy, Inbox },
  data() {
    return {
      dropdownMenuVisible: false,
    }
  },
  computed: {
    user() {
      return this.$page.props.auth.user ?? null
    },
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
      this.$inertia.post(route('logout'))
    },
    search() {
      this.$inertia.get(route('search'))
    },
  },
}
</script>
