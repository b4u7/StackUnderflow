<template>
  <div :class="[{ 'alert--fullwidth': fullwidth }, `alert--${kind}`]" class="alert">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'Alert',
  props: {
    kind: {
      type: String,
      required: true,
    },
    fullwidth: {
      type: Boolean,
      default: false,
    },
  },
}
</script>
