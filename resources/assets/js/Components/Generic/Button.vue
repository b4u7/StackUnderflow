<template>
  <Link :href="href" :as="as"></Link>
</template>

<script>
export default {
  name: 'Button',
  props: {
    as: {
      type: String,
      default: 'button',
    },
    classes: {
      type: Array,
      default: [],
    },
    href: {
      type: String,
      default: '#',
    },
  },
}
</script>
