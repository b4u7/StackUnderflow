<template>
  <a :href="route('users.show', user.id)">
    <div class="user-card">
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
    </div>
  </a>
</template>

<script>
export default {
  name: "UserCard",
  props: {
    user: {
      type: Object,
      required: true
    }
  }
};
</script>
