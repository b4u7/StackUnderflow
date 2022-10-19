<template>
  <form :method="method">
    <slot />
  </form>
</template>

<script>
export default {
  name: 'FormComponent',
  props: {
    method: {
      type: String,
      required: true,
    },
  },
}
</script>
