<template>
  <div>
    <navbar></navbar>
    <secondary-navbar></secondary-navbar>
    <main class="mt-8">
      <slot></slot>
    </main>
  </div>
</template>

<script>
import Navbar from '../Components/Navbar'
import SecondaryNavbar from '../Components/SecondaryNavbar'

export default {
  name: 'AppLayout',
  components: { SecondaryNavbar, Navbar },
}
</script>
