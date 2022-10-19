<template>
  <div
    :class="{ 'w-full': this.fullwidth, [`alert--${this.kind}`]: true }"
    class="mx-auto flex max-w-prose gap-4 rounded-md bg-white py-3 px-4 text-slate-900"
  >
    <div>
      <slot name="icon"></slot>
    </div>
    <div>
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AlertComponent',
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
