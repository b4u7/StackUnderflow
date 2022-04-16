<template>
  <div class="user-card">
    <div class="user-card__header">
      <figure>
        <img :src="user.avatar" class="user-card__header__background" :alt="`${user.name}'s header background`" />
      </figure>
    </div>
    <div class="user-card__body">
      <div class="user-card__user">
        <figure>
          <img :src="user.avatar" class="user-card__user__avatar" alt="User avatar" />
        </figure>
        <p class="user-card__user__name">
          <a :href="route('user.show', this.user)" v-text="user.name" />
        </p>
        <p class="user-card__user__username" v-text="`@${user.username}`" />
        <p class="user-card__user__bio" v-text="user.biography" />
      </div>
    </div>
    <div class="user-card__footer"></div>
  </div>
</template>

<script>
export default {
  name: 'UserCard',
  props: {
    user: {
      type: Object,
      required: true
    }
  }
}
</script>
