<template>
  <div class="notifications"></div>
</template>

<script>
export default {
  name: 'Notifications',
  inject: ['echo'],
  computed: {
    user() {
      return this.$page.props.auth.user
    },
  },
  created() {
    this.echo.private(`notifications.${this.user.id}`).listen('.notification.received')
  },
}
</script>
