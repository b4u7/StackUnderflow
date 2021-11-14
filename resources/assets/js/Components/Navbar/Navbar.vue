<template>
  <nav class="navbar navbar--primary">
    <ul class="navbar__start">
      <li class="navbar__item">
        <a class="navbar__logo" :href="route('home')"> SU </a>
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
        <li class="relative navbar__item" @click="toggleDropdown">
          <button type="button">
            <img :src="user.avatar" class="navbar__user" alt="Your user avatar" />
          </button>
          <transition name="dropdown-transition">
            <div v-if="dropdownMenuVisible" class="dropdown">
              <div class="dropdown__container">
                <a :href="route('user.show', user)" class="dropdown__item"> Profile </a>
                <a :href="route('user.edit', user)" class="dropdown__item"> Edit profile </a>
                <form class="dropdown__item" @submit.prevent="logout">
                  <button type="submit">Logout</button>
                </form>
              </div>
            </div>
          </transition>
        </li>
      </template>
      <template v-else>
        <li class="navbar__item">
          <a :href="route('login')"> Login </a>
        </li>
        <li class="navbar__item">
          <a :href="route('register')"> Register </a>
        </li>
      </template>
    </ul>
  </nav>
</template>

<script>
import Inbox from '@/Components/Navbar/Inbox'

export default {
  name: 'Navbar',
  components: { Inbox },
  data() {
    return {
      dropdownMenuVisible: false,
    }
  },
  computed: {
    user() {
      return this.$page.props.auth ? this.$page.props.auth.user : null
    },
  },
  methods: {
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
