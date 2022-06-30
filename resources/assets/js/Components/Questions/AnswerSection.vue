<template>
  <div class="answer-section">
    <div class="actions">
      <votes
        :can-vote="permissions.canVote"
        :total-votes="answer.votes_sum_vote || 0"
        :user-vote="answer.user_vote || 0"
        @upvoted="addVote"
        @downvoted="removeVote"
      />
      <solution
        v-if="permissions.canMarkSolution"
        :can-mark-solution="permissions.canMarkSolution"
        :active="isSolution"
        @mark-solution="markSolution"
      />
    </div>
    <answer-card
      :answer="answer"
      :is-solution="isSolution"
      :permissions="permissions"
      :is-trashed="!!this.answer.deleted_at"
    />
  </div>
</template>

<script>
import AnswerCard from '@/Components/Questions/Answer'
import Votes from '@/Components/Questions/Actions/Votes'
import Solution from '@/Components/Questions/Actions/Solution'

export default {
  name: 'AnswerSection',
  components: { Solution, AnswerCard, Votes },
  props: {
    answer: {
      type: Object,
      required: true,
    },
    isSolution: {
      type: Boolean,
      required: true,
    },
    permissions: {
      type: Object,
      required: true,
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
      let voteSum = this.answer.votes_sum_vote

      if (voteSum > 0) {
        return this.classes.success
      } else if (voteSum < 0) {
        return this.classes.danger
      }
    },
    userVote() {
      return this.userQuestionVote?.vote ?? 0
    },
  },
  methods: {
    async addVote() {
      await this.$inertia.post(route('questions.answers.upvote', [this.answer.question_id, this.answer]), {
        preserveScroll: true,
      })

      this.updateVotes(1)
    },
    async removeVote() {
      await this.$inertia.post(route('questions.answers.downvote', [this.answer.question_id, this.answer]), {
        preserveScroll: true,
      })

      this.updateVotes(-1)
    },
    updateVotes(newUserVote) {
      if (this.answer.user_vote !== -1 && !this.answer.user_vote) {
        this.answer.user_vote = newUserVote
        this.answer.votes_sum_vote += newUserVote

        return
      }

      const curVote = this.answer.user_vote
      this.answer.votes_sum_vote -= curVote

      if (curVote !== newUserVote) {
        this.answer.votes_sum_vote += newUserVote
        this.answer.user_vote = newUserVote

        return
      }

      this.answer.user_vote = null
    },
    markSolution() {
      this.$inertia.post(route('questions.answers.solution', [this.answer.question_id, this.answer]))
    },
  },
}
</script>

<style scoped></style>
