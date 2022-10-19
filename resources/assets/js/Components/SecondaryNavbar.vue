<template>
  <nav class="bg-slate-800 text-sm">
    <div class="container relative mx-auto flex h-12 items-center justify-between">
      <div class="flex h-full flex-shrink-2 flex-grow justify-start space-x-4">
        <Link
          v-for="link in links"
          :key="link.title"
          :href="link.route"
          :class="[link.isActive() ? 'text-slate-50' : 'text-slate-400']"
          class="relative inline-flex h-full items-center font-medium hover:text-slate-200"
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
