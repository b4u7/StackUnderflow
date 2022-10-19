<template>
  <Link :href="route('users.show', user.id)">
    <Card
      class="group h-full w-full overflow-hidden border border-transparent hover:-translate-y-1 hover:border-primary-600 motion-safe:transition"
    >
      <template #header>
        <div class="h-28 max-h-28 overflow-hidden bg-slate-100">
          <img
            v-if="user.header"
            :src="user.header"
            :alt="`${user.name}'s header background`"
            class="h-full w-full origin-center object-cover object-center"
          />
        </div>
      </template>
      <template #body>
        <div class="pb-4">
          <div class="relative z-10 -mt-8 h-20 w-20 overflow-hidden rounded-full border-4 border-white">
            <img
              :src="user.avatar"
              :alt="`User avatar for ${user.username}`"
              class="h-full w-full object-cover object-center"
            />
          </div>
          <p class="mt-1 font-semibold group-hover:text-primary-700" v-text="user.name" />
          <p class="mt-1 text-sm" v-text="`@${user.username}`" />
          <p class="mt-4 text-sm text-slate-600" v-text="user.biography" />
        </div>
      </template>
    </Card>
  </Link>
  <!--
  <a :href="route('users.show', user.id)" class="user-card">
    <div class="user-card__header">
      <img
        v-if="user.header"
        class="user-card__header__background"
        :src="user.header"
        :alt="`${user.name}'s header background`"
      />
    </div>
    <div class="user-card__body">
      <div class="user-card__user">
        <div class="user-card__user__avatar">
          <img :src="user.avatar" :alt="`User avatar for ${user.username}`" />
        </div>
        <p class="user-card__user__name" v-text="user.name" />
        <p class="user-card__user__username" v-text="`@${user.username}`" />
        <p class="user-card__user__bio" v-text="user.biography" />
      </div>
    </div>
    <div class="user-card__footer"></div>
  </a>
  -->
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import Card from '@/Components/Generic/Card'

export default {
  name: 'UserCard',
  components: { Card, Link },
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
}
</script>
