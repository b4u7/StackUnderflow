<template>
  <form @submit.prevent="bookmark">
    <button :class="classes" :disabled="disabled" class="actions__item actions__bookmark" type="submit">
      <font-awesome-icon v-if="bookmarked" icon="fa-solid fa-bookmark" />
      <font-awesome-icon v-else icon="fa-regular fa-bookmark" />
    </button>
  </form>
</template>

<script>
export default {
  name: 'Bookmark',
  props: {
    bookmarked: {
      type: Boolean,
      required: true,
    },
    canBookmark: {
      type: Boolean,
      required: true,
    },
    canUnbookmark: {
      type: Boolean,
      required: true,
    },
  },
  methods: {
    bookmark() {
      if (this.disabled) {
        return
      }

      this.$emit('bookmark', this.bookmarked)
    },
  },
  computed: {
    disabled() {
      return (this.bookmarked && !this.canUnbookmark) || (!this.bookmarked && !this.canBookmark)
    },
    classes() {
      return {
        'actions__item--active': this.bookmarked,
      }
    },
  },
}
</script>
