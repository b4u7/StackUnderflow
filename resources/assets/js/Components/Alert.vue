<template>
  <div :class="{ classes, ...`alert--${this.kind}` }" class="alert alert--">
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
  data() {
    return {
      classes: {
        'alert--fullwidth': this.fullwidth,
      },
    }
  },
}
</script>
