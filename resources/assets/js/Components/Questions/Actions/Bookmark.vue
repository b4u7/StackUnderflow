<template>
  <form @submit.prevent="bookmark">
    <button :class="classes" :disabled="disabled" class="actions__item actions__bookmark" type="submit">
      <font-awesome-icon v-if="mutableBookmarked" icon="fa-solid fa-bookmark" />
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
      required: true
    },
    canBookmark: {
      type: Boolean,
      required: true
    },
    canUnbookmark: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      mutableBookmarked: this.active
    }
  },
  methods: {
    bookmark() {
      if (this.disabled) {
        return
      }

      this.mutableBookmarked = !this.mutableBookmarked
      this.$emit('bookmark', this.mutableBookmarked)
    }
  },
  computed: {
    disabled() {
      return (this.mutableBookmarked && !this.canUnbookmark) || (!this.mutableBookmarked && !this.canBookmark)
    },
    classes() {
      return {
        'actions__item--active': this.mutableBookmarked
      }
    }
  }
}
</script>
