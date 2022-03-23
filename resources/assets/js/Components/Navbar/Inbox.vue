<template>
  <li class="relative navbar__item" ref="dropdown">
    <tippy message="Notifications">
      <button class="button button--primary button--icon" type="button" @click.prevent="toggleInbox">
        <font-awesome-icon icon="fa-solid fa-inbox fa-lg fa-fw" />
      </button>
    </tippy>
    <transition name="dropdown-transition">
      <div v-if="visible" class="inbox">
        <div class="inbox__header">
          <div class="inbox__header__left">
            <template v-if="notificationsCount">
              <tippy :message="`Mark ${notificationsCount} as read`">
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
            <tippy message="Settings">
              <button class="button button--white button--icon" type="button" @click.prevent="settingsClick">
                <font-awesome-icon icon="fa-solid fa-gear fa-lg fa-fw" />
              </button>
            </tippy>
            <button class="button button--white button--icon" type="button" @click.prevent="toggleInbox">
              <font-awesome-icon icon="fa-solid fa-xmark fa-lg fa-fw" />
            </button>
          </div>
        </div>
        <div class="inbox__content">
          <template v-if="notificationsCount">
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
      visible: false
    }
  },
  computed: {
    user() {
      return this.$page.props.auth.user
    },
    notifications() {
      return this.user?.notifications
    },
    notificationsCount() {
      return this.user?.notifications.length
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
    markAllRead() {

    },
    // TODO: Implement user settings page
    settingsClick() {
      this.$inertia.post(route('user.show'))
    }
  }
}
</script>
