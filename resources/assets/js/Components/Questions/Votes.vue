<template>
  <div class="voting">
    <form @submit.prevent="addVote">
      <button
        :class="{['voting__vote-up--active']: userVote === 1}"
        :disabled="!canVote"
        class="voting__vote-up"
        type="submit"
      >
        <i class="fas fa-angle-up"></i>
      </button>
    </form>
    <p class="voting__count">
      <span :class="voteSumColour">
        {{ totalVotes }}
      </span>
    </p>
    <form @submit.prevent="removeVote">
      <button
        :class="{['voting__vote-down--active']: userVote === -1}"
        :disabled="!canVote"
        class="voting__vote-down"
        type="submit"
      >
        <i class="fas fa-angle-down"></i>
      </button>
    </form>
  </div>
</template>

<script>
export default {
  name: "Votes",
  props: {
    totalVotes: {
      type: Number,
      required: true
    },
    canVote: {
      type: Boolean,
      required: true
    },
    userVote: {
      type: Number,
      required: false
    }
  },
  data() {
    return {
      classes: {
        success: "text-emerald-600",
        danger: "text-red-600"
      }
    };
  },
  computed: {
    voteSumColour() {
      if (this.totalVotes > 0) {
        return this.classes.success;
      }

      if (this.totalVotes < 0) {
        return this.classes.danger;
      }
    }
  },
  methods: {
    addVote() {
      this.$emit("upvoted");
    },
    removeVote() {
      this.$emit("downvoted");
    }
  }
};
</script>
