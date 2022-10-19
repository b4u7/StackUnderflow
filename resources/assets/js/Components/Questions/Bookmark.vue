<template>
  <form @submit.prevent="bookmark">
    <button
      :class="{ 'text-primary-500 hover:text-primary-600': bookmarked }"
      class="mt-2 text-3xl text-slate-300 enabled:hover:text-slate-400 disabled:cursor-not-allowed"
      type="submit"
      :disabled="disabled"
    >
      <font-awesome-icon v-if="bookmarked" icon="fa-solid fa-bookmark" />
      <font-awesome-icon v-else icon="fa-regular fa-bookmark" />
    </button>
  </form>
</template>

<script>
export default {
  name: 'BookmarkComponent',
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
  },
}
</script>
