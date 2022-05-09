<template>
  <section class="hero hero--primary">
    <div class="hero__body">
      <div class="container">
        <slot name="body"></slot>
      </div>
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
