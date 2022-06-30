<template>
  <div>
    <main>
      <slot></slot>
    </main>
    <main-footer />
  </div>
</template>

<script>
import MainFooter from '@/Components/Generic/Footer'

export default {
  name: 'HomeLayout',
  components: { MainFooter },
}
</script>
