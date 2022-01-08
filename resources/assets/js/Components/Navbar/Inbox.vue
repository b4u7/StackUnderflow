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
          <div v-for="(notification, index) in notifications" :key="index" class="inbox__notification">
            <div class="inbox__notification__content">
              <!-- TODO: Show notification type in here (Answer, Comment, Rep) -->
              <div class="inbox__notification__subtitle">
                <i class="inbox__notification__icon fas fa-comment-alt"></i>
                <p>
                  Answer by
                  <a class="inbox__notification__user" :href="notification.data.author.url">
                    {{ notification.data.author.name }}
                  </a>
                </p>
              </div>
              <h1 class="inbox__notification__title">{{ notification.data.title }}</h1>
              <p class="inbox__notification__body">{{ notification.data.body }}</p>
            </div>
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
      return this.user?.notifications
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
