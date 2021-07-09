<template>
  <nav class="navbar navbar--primary">
    <div class="container">
      <div class="navbar__start">
        <a class="navbar__item" :href="route('home')"> StackUnderflow </a>
      </div>
      <div class="navbar__search">
        <form method="GET" :action="route('search')">
          <input class="navbar__search__control" type="text" name="search" placeholder="Search" />
        </form>
      </div>
      <div class="navbar__end">
        <div
          v-if="user"
          class="navbar__item navbar__dropdown"
          aria-expanded="false"
          aria-haspopup="true"
          @mouseover="showDropdownMenu"
          @mouseleave="hideDropdownMenu"
        >
          <div>
            <button class="navbar__user__menu">
              <img :src="user.avatar" class="navbar__user__avatar" alt="Your user avatar" />
            </button>
          </div>
          <transition name="navbar__dropdown__transition">
            <div v-if="dropdownMenuVisible" class="navbar__dropdown__container">
              <a :href="route('user.show', user)" class="navbar__dropdown__item"> Profile </a>
              <a :href="route('user.edit', user)" class="navbar__dropdown__item"> Edit profile </a>
              <form class="navbar__dropdown__item" @submit.prevent="logout">
                <!-- TODO: Inertia -->
                <button type="submit">Logout</button>
              </form>
            </div>
          </transition>
        </div>
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
    showDropdownMenu() {
      this.dropdownMenuVisible = true
    },
    hideDropdownMenu() {
      this.dropdownMenuVisible = false
    },
    logout() {
      this.$inertia.post(route('logout'))
    },
  },
}
</script>
