<template>
  <nav class="secondary-navbar">
    <div class="container">
      <div class="secondary-navbar__start">
        <Link
          v-for="link in links"
          :key="link.title"
          :href="link.route"
          :class="{ 'secondary-navbar__item--active': link.isActive() }"
          class="secondary-navbar__item"
          v-text="link.title"
        />
      </div>
    </div>
  </nav>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  name: 'SecondaryNavbar',
  components: { Link },
  data() {
    return {
      links: [
        {
          title: 'Questions',
          route: this.route('questions.index'),
          isActive: () => this.$page.url.startsWith('/questions'),
        },
        { title: 'Users', route: this.route('users.index'), isActive: () => this.$page.url.startsWith('/users') },
      ],
    }
  },
}
</script>
