<template>
  <div>
    <navbar />
    <secondary-navbar />
    <main class="mt-8">
      <notifications />
      <slot></slot>
    </main>
  </div>
</template>

<script>
import Navbar from '@/Components/Navbar'
import Notifications from '@/Components/Notifications'
import SecondaryNavbar from '@/Components/SecondaryNavbar'

export default {
  name: 'AppLayout',
  components: { SecondaryNavbar, Navbar, Notifications },
}
</script>
