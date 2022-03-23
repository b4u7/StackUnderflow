<template>
  <div class="user-card" @click="onUserCardClick">
    <div class="user-card__body">
      <div class="user-card__user">
        <img :src="user.avatar" class="user-card__user__avatar" alt="User avatar">
        <a class="user-card__user__name" v-text="user.name" />
      </div>
    </div>
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
  },
  methods: {
    onUserCardClick() {
      this.$inertia.get(route('user.show', this.user))
    }
  }
}
</script>
