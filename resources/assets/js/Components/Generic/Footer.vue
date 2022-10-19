<template>
  <footer class="bg-slate-800 pt-24 pb-8 text-slate-500">
    <div class="container">
      <div class="space-y-4">
        <h6 class="text-xl font-semibold text-slate-300">Stack Underflow</h6>
        <ul>
          <li class="text-slate-400 hover:text-slate-300 focus:text-slate-200 active:text-slate-200">
            <Link :href="route('questions.index')"> Questions </Link>
          </li>
        </ul>
      </div>
      <hr class="my-8 border-slate-600" />
      <div class="text-center">Copyright © 2020 - {{ currentYear }} Stack Underflow, All Rights Reserved.</div>
    </div>
  </footer>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  name: 'FooterComponent',
  components: { Link },
  computed: {
    currentYear() {
      return new Date().getFullYear()
    },
  },
}
</script>
