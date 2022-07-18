<template>
  <div class="answer-section">
    <div class="actions">
      <votes
        :can-vote="permissions.canVote"
        :total-votes="mutableAnswer.votes_sum_vote || 0"
        :user-vote="mutableAnswer.user_vote || 0"
        @upvoted="addVote"
        @downvoted="removeVote"
      />
      <!-- FIXME: Temporary solution -->
      <solution
        v-if="permissions.canMarkSolution || (!permissions.canMarkSolution && isSolution)"
        :can-mark-solution="permissions.canMarkSolution"
        :active="isSolution"
        @mark-solution="markSolution"
      />
    </div>
    <answer-card
      :answer="mutableAnswer"
      :is-solution="isSolution"
      :permissions="permissions"
      :is-trashed="!!mutableAnswer.deleted_at"
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
      mutableAnswer: null,
    }
  },
  watch: {
    answer: {
      immediate: true,
      handler(newVal) {
        this.mutableAnswer = newVal
      },
    },
  },
  computed: {
    voteSumColour() {
      let voteSum = this.mutableAnswer.votes_sum_vote

      if (voteSum > 0) {
        return this.classes.success
      } else if (voteSum < 0) {
        return this.classes.danger
      }

      return ''
    },
    userVote() {
      return this.userQuestionVote?.vote ?? 0
    },
  },
  methods: {
    async addVote() {
      await this.$inertia.post(
        route('questions.answers.upvote', [this.mutableAnswer.question_id, this.mutableAnswer]),
        null,
        {
          preserveScroll: true,
        }
      )

      this.updateVotes(1)
    },
    async removeVote() {
      await this.$inertia.post(
        route('questions.answers.downvote', [this.mutableAnswer.question_id, this.mutableAnswer]),
        null,
        {
          preserveScroll: true,
        }
      )

      this.updateVotes(-1)
    },
    updateVotes(newUserVote) {
      if (this.mutableAnswer.user_vote !== -1 && !this.mutableAnswer.user_vote) {
        this.mutableAnswer.user_vote = newUserVote
        this.mutableAnswer.votes_sum_vote += newUserVote

        return
      }

      const curVote = this.mutableAnswer.user_vote
      this.mutableAnswer.votes_sum_vote -= curVote

      if (curVote !== newUserVote) {
        this.mutableAnswer.votes_sum_vote += newUserVote
        this.mutableAnswer.user_vote = newUserVote

        return
      }

      this.mutableAnswer.user_vote = null
    },
    markSolution() {
      this.$inertia.post(route('questions.answers.solution', [this.mutableAnswer.question_id, this.mutableAnswer]))
    },
  },
}
</script>

<style scoped></style>
