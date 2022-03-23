<template>
  <div>
    <navbar />
    <secondary-navbar class="mb-8" />
    <main>
      <slot></slot>
    </main>
  </div>
</template>

<script>
import Navbar from '@/Components/Navbar/Navbar'
import SecondaryNavbar from '@/Components/SecondaryNavbar'

export default {
  name: 'AppLayout',
  components: { Navbar, SecondaryNavbar }
}
</script>
