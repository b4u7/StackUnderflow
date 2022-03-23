<template>
  <section class="section">
    <!-- w-full max-w-8xl mx-auto -->
    <div class="container">
      <div class="user-profile">
        <div class="user-profile__header">
          <div class="user-profile__header__background"></div>
          <div class="user-profile__header__name"></div>
          <div class="user-profile__header__username"></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'Index',
  props: {
    User: {
      type: Object, // ?
      required: true,
    },
  },
}
</script>
