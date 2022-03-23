<template>
  <section class="hero hero--large hero--primary">
    <div class="hero__body">
      <div class="container">
        <h1 class="hero__leading" v-if="leading" v-html="leading" />
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
