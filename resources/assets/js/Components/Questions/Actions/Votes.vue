<template>
  <div class="actions__voting">
    <form @submit.prevent="addVote">
      <button
        :class="{
          ['actions__item--active']: userVote === 1,
          'actions__item--disabled': !this.canVote,
        }"
        :disabled="!canVote"
        type="submit"
        class="actions__item actions__vote-up"
      >
        <i class="fas fa-angle-up"></i>
      </button>
    </form>
    <p class="actions__item actions__vote-count">
      <span :class="voteSumColour">
        {{ totalVotes }}
      </span>
    </p>
    <form @submit.prevent="removeVote">
      <button
        :class="{
          ['actions__item--active']: userVote === -1,
          'actions__item--disabled': !this.canVote,
        }"
        :disabled="!canVote"
        type="submit"
        class="actions__item actions__vote-down"
      >
        <i class="fas fa-angle-down"></i>
      </button>
    </form>
  </div>
</template>

<script>
export default {
  name: 'Votes',
  props: {
    canVote: {
      type: Boolean,
      required: true,
    },
    totalVotes: {
      type: Number,
      required: true,
    },
    userVote: {
      type: Number,
      required: false,
    },
  },
  data() {
    return {
      classes: {
        success: 'text-emerald-600',
        danger: 'text-red-600',
      },
    }
  },
  computed: {
    voteSumColour() {
      if (this.totalVotes > 0) {
        return this.classes.success
      }

      if (this.totalVotes < 0) {
        return this.classes.danger
      }
    },
  },
  methods: {
    addVote() {
      this.$emit('upvoted')
    },
    removeVote() {
      this.$emit('downvoted')
    },
  },
}
</script>
