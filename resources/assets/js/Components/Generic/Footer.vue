<template>
  <footer class="footer">
    <div class="container">
      <div class="footer__menu">
        <h6 class="footer__title footer__logo">StackUnderflow</h6>
        <ul>
          <li class="footer__list">
            <Link :href="route('questions.index')"> Questions </Link>
          </li>
        </ul>
      </div>
      <hr class="footer__divider" />
      <div class="text-center">Copyright © 2020 - {{ currentYear }} StackUnderflow, All Rights Reserved.</div>
    </div>
  </footer>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  name: 'MainFooter',
  components: { Link },
  computed: {
    currentYear() {
      return new Date().getFullYear()
    },
  },
}
</script>
