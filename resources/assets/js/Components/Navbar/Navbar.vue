<template>
  <nav :class="[dark ? 'bg-slate-900' : 'bg-primary-600']" class="z-0 flex h-16 items-center justify-between px-4">
    <ul class="flex h-full flex-shrink-2 flex-grow justify-start">
      <NavbarItem>
        <a class="font-epilogue text-xl font-semibold" :href="route('home')">
          <font-awesome-icon icon="fa-solid fa-layer-group" class="rotate-180" />
          <span class="ml-2 hidden sm:inline">Stack Underflow</span>
        </a>
      </NavbarItem>
    </ul>
    <ul class="flex h-full flex-shrink flex-grow-2 justify-center">
      <NavbarItem>
        <form @submit.prevent="search">
          <input
            :class="[
              dark
                ? 'bg-slate-800 text-slate-300 placeholder-slate-400 hover:border-slate-500 focus:border-slate-200'
                : 'bg-primary-500 text-white placeholder-primary-300 hover:border-primary-400',
            ]"
            class="relative hidden w-80 max-w-2xl rounded-md border-2 border-transparent text-sm font-medium transition duration-200 focus:border-slate-200 focus:bg-white focus:font-medium focus:text-slate-600 focus:placeholder-slate-400 focus:outline-none focus:ring-transparent active:border-slate-200 active:bg-white active:font-medium active:placeholder-slate-400 active:outline-none active:ring-transparent md:inline-flex md:flex-shrink md:flex-grow"
            type="text"
            autocomplete="off"
            placeholder="Search questions"
            spellcheck="false"
            v-model="searchQuery"
          />
        </form>
      </NavbarItem>
    </ul>
    <ul class="flex h-full flex-shrink-2 flex-grow justify-end space-x-4">
      <template v-if="user">
        <Inbox />
        <NavbarItem>
          <Dropdown origin="origin-top-right" position="top-14 right-4">
            <template #button>
              <button type="button" class="appearance-none">
                <img :src="user.avatar" class="h-8 w-8 rounded-full border-2 border-white" alt="Your user avatar" />
              </button>
            </template>
            <template #content>
              <div class="flex flex-col p-2">
                <DropdownButton type="Link" :href="route('users.show', user)">Profile</DropdownButton>
                <DropdownButton type="Link" :href="route('users.bookmarks.index', user)">My bookmarks</DropdownButton>
                <DropdownButton type="Link" :href="route('users.edit', user)">Account settings</DropdownButton>
                <hr class="my-2" />
                <DropdownButton type="button" @click.prevent="logout">Logout</DropdownButton>
              </div>
            </template>
          </Dropdown>
        </NavbarItem>
      </template>
      <template v-else>
        <NavbarItem>
          <a :href="route('login')" class="button button--primary">Login</a>
        </NavbarItem>
        <NavbarItem>
          <a :href="route('register')" class="button button--white">Register</a>
        </NavbarItem>
      </template>
    </ul>
  </nav>
</template>

<script>
import Inbox from '@/Components/Navbar/Inbox'
import NavbarItem from '@/Components/Navbar/NavbarItem'
import Dropdown from '@/Components/Navbar/Dropdown'
import DropdownButton from '@/Components/Navbar/DropdownButton'

export default {
  name: 'NavbarComponent',
  components: { Inbox, NavbarItem, Dropdown, DropdownButton },
  props: {
    dark: {
      type: Boolean,
    },
  },
  data() {
    return {
      dropdownMenuVisible: false,
      pendingSearch: null,
      searchQuery: '',
    }
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
    },
  },
  methods: {
    logout() {
      console.log('logout')
      this.$inertia.post(this.route('logout'))
    },
    search() {
      this.$inertia.get(
        this.route(
          'questions.index',
          { query: this.searchQuery },
          {
            preserveScroll: true,
            preserveState: true,
          }
        )
      )
    },
  },
}
</script>
