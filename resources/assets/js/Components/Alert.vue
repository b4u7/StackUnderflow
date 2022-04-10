<template>
  <div :class="classes" class="alert">
    <p>
      <slot></slot>
    </p>
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
  computed: {
    classes() {
      return {
        'alert--fullwidth': this.fullwidth,
        [`alert--${this.kind}`]: true,
      }
    },
  },
}
</script>
