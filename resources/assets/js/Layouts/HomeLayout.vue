<template>
  <div>
    <navbar />
    <hero leading="Learn, Share, Build" subtitle="For developers, by developers" />
    <main>
      <slot></slot>
    </main>
  </div>
</template>

<script>
import Hero from '@/Components/Home/Hero'
import SecondaryNavbar from '@/Components/SecondaryNavbar'
import Navbar from '@/Components/Navbar/Navbar'

export default {
  name: 'HomeLayout',
  components: { Navbar, SecondaryNavbar, Hero },
}
</script>
