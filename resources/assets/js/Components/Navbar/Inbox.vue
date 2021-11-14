<template>
  <li class="relative navbar__item">
    <button type="button" @click.prevent="toggleInbox">
      <i class="text-2xl fas fa-inbox"></i>
    </button>
    <transition name="dropdown-transition">
      <div v-if="visible" class="inbox">
        <div class="inbox__header">
          <div class="inbox__header__left"></div>
          <div class="inbox__header__center">
            <p>Notifications</p>
          </div>
          <div class="inbox__header__right">
            <button class="button button--icon" type="button">
              <i class="fas fa-cog"></i>
            </button>
            <button class="button button--icon" type="button">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="inbox__content">
          <div v-for="(notification, index) in notifications" :key="index" class="inbox__item">
            <h1>{{ notification.data.title }}</h1>
            <p>{{ notification.data.body }}</p>
          </div>
        </div>
      </div>
    </transition>
  </li>
</template>

<script>
export default {
  name: 'Inbox',
  inject: ['echo'],
  data() {
    return {
      visible: false,
    }
  },
  computed: {
    user() {
      return this.$page.props.auth.user
    },
    notifications() {
      return this.$page.props.auth.user.notifications
    },
  },
  created() {
    this.echo.private(`notifications.${this.user.id}`).listen('.notification.received')
  },
  methods: {
    toggleInbox() {
      this.visible = !this.visible
    },
  },
}
</script>
