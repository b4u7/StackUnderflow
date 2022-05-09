<template>
  <div>
    <navbar />
    <main>
      <slot></slot>
    </main>
    <main-footer />
  </div>
</template>

<script>
import Navbar from '@/Components/Navbar/Navbar'
import MainFooter from '@/Components/Generic/Footer'

export default {
  name: 'HomeLayout',
  components: { MainFooter, Navbar },
}
</script>
