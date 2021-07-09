<template>
  <div class="answer-section">
    <div class="question-controls">
      <form @submit.prevent="addVote">
        <button
          :class="userAnswerVote && userAnswerVote.vote === 1 ? 'question-controls__vote-up--active' : ''"
          :disabled="!permissions.canVote"
          class="question-controls__vote-up"
          type="submit"
        >
          <i class="fas fa-angle-up"></i>
        </button>
      </form>
      <p class="question-controls__vote-count">
        <span v-if="answer.votes_sum_vote" :class="voteSumColour">
          {{ answer.votes_sum_vote }}
        </span>
        <span v-else> 0 </span>
      </p>
      <form @submit.prevent="removeVote">
        <button
          :class="userAnswerVote && userAnswerVote.vote === -1 ? 'question-controls__vote-down--active' : ''"
          :disabled="!permissions.canVote"
          class="question-controls__vote-down"
          type="submit"
        >
          <i class="fas fa-angle-down"></i>
        </button>
      </form>
    </div>

    <answer-card :answer="answer" :permissions="permissions"></answer-card>
  </div>
</template>

<script>
import AnswerCard from './AnswerCard'

export default {
  name: 'AnswerSection',
  components: { AnswerCard },
  props: {
    answer: {
      type: Object,
      required: true,
    },
    permissions: {
      type: Object,
      required: true,
    },
    userAnswerVote: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      classes: {
        success: 'text-green-600',
        danger: 'text-red-600',
      },
    }
  },
  computed: {
    voteSumColour() {
      let voteSum = this.answer.votes_sum_vote

      if (voteSum > 0) {
        return this.classes.success
      } else if (voteSum < 0) {
        return this.classes.danger
      }
    },
  },
  methods: {
    addVote() {
      this.$inertia.post(route('answers.upvote', [this.answer.question_id,  this.answer] ))
    },
    removeVote() {
      this.$inertia.post(route('answers.downvote', [this.answer.question_id, this.answer]))
    },
  },
}
</script>

<style scoped></style>
