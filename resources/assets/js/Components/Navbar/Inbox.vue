<template>
  <NavbarItem ref="dropdown" class="relative">
    <Dropdown origin="origin-top-right" position="top-14 right-4" minWidth="400px">
      <template #button>
        <tippy message="Notifications">
          <button class="button button--primary button--icon" type="button">
            <span class="relative inline-block">
              <font-awesome-icon icon="fa-solid fa-inbox fa-lg fa-fw" />
              <Badge v-if="notificationCountBadge" v-text="notificationCountBadge" />
            </span>
          </button>
        </tippy>
      </template>
      <template #content="{ actions: { close } }">
        <div class="flex min-h-[3rem] flex-row items-center overflow-hidden py-1 px-2 shadow-sm">
          <div class="w-16">
            <tippy v-if="notificationCountTotal" :message="`Mark ${notificationCountTotal} as read`">
              <button class="button button--white button--icon" type="button" @click.prevent="markAllRead">
                <font-awesome-icon icon="fa-solid fa-envelope-open" />
              </button>
            </tippy>
          </div>
          <div class="inline-flex flex-grow justify-center">
            <p>Notifications</p>
          </div>
          <div>
            <tippy message="Settings">
              <button class="button button--white button--icon" type="button">
                <font-awesome-icon icon="fa-solid fa-gear fa-lg fa-fw" />
              </button>
            </tippy>
            <button class="button button--white button--icon" type="button" @click.prevent="close">
              <font-awesome-icon icon="fa-solid fa-xmark fa-lg fa-fw" />
            </button>
          </div>
        </div>
        <div class="flex max-h-[400px] flex-grow flex-col overflow-y-auto">
          <template v-if="notificationCountTotal">
            <a
              v-for="notification in notifications"
              :key="notification.id"
              class="flex flex-row p-4 hover:bg-slate-50 focus:bg-slate-100 active:bg-slate-100"
              href="#"
              @click.prevent="onNotificationClick(notification.id)"
            >
              <div>
                <!-- TODO: Show notification type in here (Answer, Comment, Rep) -->
                <div class="flex flex-row items-center space-x-2 text-sm text-slate-500">
                  <font-awesome-icon icon="text-sm text-primary-600 fa-solid fa-comment-alt fa-lg fa-fw" />
                  <p>
                    Answer by
                    <a
                      class="text-slate-900 hover:text-primary-700 hover:underline focus:text-primary-500 focus:underline active:text-primary-500 active:underline"
                      :href="notification.data.author.url"
                      v-text="notification.data.author.name"
                    />
                  </p>
                </div>
                <h1 class="text-slate-800" v-text="notification.data.title" />
                <p class="text-slate-500" v-text="notification.data.body" />
              </div>
            </a>
          </template>
          <template v-else>
            <div class="p-4 text-center">
              <p>Your inbox is clear!</p>
            </div>
          </template>
        </div>
        <!-- </div> -->
      </template>
    </Dropdown>
  </NavbarItem>
</template>

<script>
import Badge from '@/Components/Generic/Badge.vue'
import NavbarItem from '@/Components/Navbar/NavbarItem'
import Tippy from '@/Components/Tippy'
import Dropdown from './Dropdown.vue'

export default {
  name: 'NavbarInboxComponent',
  components: { Badge, NavbarItem, Tippy, Dropdown },
  inject: ['echo'],
  created() {
    this.echo.private(`notifications.${this.user.id}`).listen('.notification.received')
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
    onNotificationClick(id) {
      this.$inertia.get(route('notifications.show', id))
    },
    markAllRead() {
      this.$inertia.post(route('notifications.mark-all-read'))
    },
    settingsClick() {
      this.$inertia.post(route('users.show'))
    },
  },
}
</script>
