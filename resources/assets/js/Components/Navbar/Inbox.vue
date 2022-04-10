<template>
  <li class="relative navbar__item" ref="dropdown">
    <tippy message="Notifications">
      <button class="button button--primary button--icon" type="button" @click.prevent="toggleInbox">
        <span class="relative inline-block">
          <font-awesome-icon icon="fa-solid fa-inbox fa-lg fa-fw" />
          <span v-if="notificationCountBadge" class="badge" v-text="notificationCountBadge" />
        </span>
      </button>
    </tippy>
    <transition name="dropdown-transition">
      <div v-if="visible" class="inbox">
        <div class="inbox__header">
          <div class="inbox__header__left">
            <template v-if="notificationCountTotal">
              <tippy :message="`Mark ${notificationCountTotal} as read`">
                <button class="button button--white button--icon" type="button" @click.prevent="markAllRead">
                  <font-awesome-icon icon="fa-solid fa-envelope-open" />
                </button>
              </tippy>
            </template>
          </div>
          <div class="inbox__header__center">
            <p>Notifications</p>
          </div>
          <div class="inbox__header__right">
            <!--            <tippy message="Settings">
                          <button class="button button&#45;&#45;white button&#45;&#45;icon" type="button" @click.prevent="settingsClick">
                            <font-awesome-icon icon="fa-solid fa-gear fa-lg fa-fw" />
                          </button>
                        </tippy>-->
            <button class="button button--white button--icon" type="button" @click.prevent="toggleInbox">
              <font-awesome-icon icon="fa-solid fa-xmark fa-lg fa-fw" />
            </button>
          </div>
        </div>
        <div class="inbox__content">
          <template v-if="notificationCountTotal">
            <a
              v-for="notification in notifications"
              :key="notification.id"
              class="inbox__notification"
              href="#"
              @click.prevent="onNotificationClick(notification.id)"
            >
              <div class="inbox__notification__content">
                <!-- TODO: Show notification type in here (Answer, Comment, Rep) -->
                <div class="inbox__notification__subtitle">
                  <font-awesome-icon icon="inbox__notification__icon fa-solid fa-comment fa-lg fa-fw" />
                  <p>
                    Answer by
                    <a
                      class="inbox__notification__user"
                      :href="notification.data.author.url"
                      v-text="notification.data.author.name"
                    />
                  </p>
                </div>
                <h1 class="inbox__notification__title" v-text="notification.data.title" />
                <p class="inbox__notification__body" v-text="notification.data.body" />
              </div>
            </a>
          </template>
          <template v-else>
            <div class="inbox__empty-state">
              <p>Your inbox is clear!</p>
            </div>
          </template>
        </div>
      </div>
    </transition>
  </li>
</template>

<script>
import Tippy from '@/Components/Tippy'

export default {
  name: 'Inbox',
  components: { Tippy },
  inject: ['echo'],
  data() {
    return {
      visible: false,
    }
  },
  created() {
    this.echo.private(`notifications.${this.user.id}`).listen('.notification.received')
  },
  mounted() {
    document.addEventListener('click', this.onDocumentClick)
  },
  beforeDestroy() {
    document.removeEventListener('click', this.onDocumentClick)
  },
  computed: {
    user() {
      return this.$page.props.auth.user
    },
    notifications() {
      return this.user?.notifications
    },
    notificationCountTotal() {
      return this.user?.notifications.length
    },
    notificationCountBadge() {
      if (!this.notificationCountTotal) {
        return
      }

      return this.notificationCountTotal > 9 ? '9+' : this.notificationCountTotal.toString()
    },
  },
  methods: {
    onDocumentClick(e) {
      if (!this.$refs.dropdown.contains(e.target)) {
        this.visible = false
      }
    },
    onNotificationClick(id) {
      this.$inertia.get(route('notifications.show', id))
    },
    toggleInbox() {
      this.visible = !this.visible
    },
    // TODO: Implement Inbox -> Mark all as read
    markAllRead() {},
    // TODO: Implement user settings page
    settingsClick() {
      this.$inertia.post(route('user.show'))
    },
  },
}
</script>
