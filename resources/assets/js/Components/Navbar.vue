<template>
  <nav class="navbar navbar--primary">
    <div class="container">
      <div class="navbar__start">
        <a class="navbar__item" :href="route('home')"> StackUnderflow </a>
      </div>
      <div class="navbar__search">
        <form method="GET" @submit.prevent="search">
          <input class="navbar__search__control" type="text" name="search" placeholder="Search" />
        </form>
      </div>
      <!-- TODO: Refactor -->
      <div class="navbar__end">
        <template v-if="user">
          <div class="navbar__item" @click="toggleDropdown">
            <button type="button">
              <img :src="user.avatar" class="navbar__user" alt="Your user avatar" />
            </button>
          </div>
          <transition name="navbar__dropdown__transition">
            <div class="navbar__dropdown">
              <div v-if="dropdownMenuVisible" class="navbar__dropdown__container">
                <a :href="route('user.show', user)" class="navbar__dropdown__item"> Profile </a>
                <a :href="route('user.edit', user)" class="navbar__dropdown__item"> Edit profile </a>
                <form class="navbar__dropdown__item" @submit.prevent="logout">
                  <button type="submit">Logout</button>
                </form>
              </div>
            </div>
          </transition>
        </template>
        <template v-else>
          <a class="navbar__item" :href="route('login')"> Login </a>
          <a class="navbar__item" :href="route('register')"> Register </a>
        </template>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Navbar',
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
