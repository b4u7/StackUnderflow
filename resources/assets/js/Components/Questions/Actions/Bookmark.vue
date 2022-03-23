<template>
  <form @submit.prevent="bookmark">
    <button :class="classes" :disabled="disabled" class="actions__item actions__bookmark" type="submit">
      <i v-if="active" class="fas fa-bookmark"></i>
      <i v-else class="far fa-bookmark"></i>
    </button>
  </form>
</template>

<script>
export default {
  name: 'Bookmark',
  props: {
    active: {
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
  data() {
    return {
      bookmarked: this.active,
    }
  },
  methods: {
    bookmark() {
      if (this.disabled) {
        return
      }

      this.bookmarked = !this.bookmarked
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
