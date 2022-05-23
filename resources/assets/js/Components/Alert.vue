<template>
  <div :class="classes" class="alert">
    <div class="alert__icon">
      <slot name="icon"></slot>
    </div>
    <div>
      <p>
        <slot></slot>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Alert',
  props: {
    kind: {
      type: String,
      required: true
    },
    fullwidth: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    classes() {
      return {
        'alert--fullwidth': this.fullwidth,
        [`alert--${this.kind}`]: true
      }
    }
  }
}
</script>
