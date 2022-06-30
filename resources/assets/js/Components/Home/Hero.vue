<template>
  <section class="hero">
    <div class="hero__header">
      <slot name="header"></slot>
    </div>
    <div class="hero__body">
      <div class="container">
        <slot name="body"></slot>
      </div>
    </div>
    <div class="hero__footer">
      <slot name="footer"></slot>
    </div>
  </section>
</template>

<script>
export default {
  name: 'Hero',
  props: {
    leading: {
      type: String,
      required: false,
    },
    subtitle: {
      type: String,
      required: false,
    },
  },
}
</script>
