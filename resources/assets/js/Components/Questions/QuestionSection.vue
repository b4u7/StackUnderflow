<template>
  <section class="section">
    <Alert v-if="isTrashed" kind="danger" class="my-8">
      <p>
        <i class="fas fa-exclamation-triangle"></i>
        This question was deleted, only admins can see it.
      </p>
    </Alert>
    <div class="flex flex-row">
      <div class="question-controls">
        <votes
          :total-votes="question.votes_sum_vote || 0"
          :can-vote="permissions.canVote"
          :user-vote="userVote"
          @upvoted="addVote"
          @downvoted="removeVote"
        />
        <form v-if="bookmark" @submit.prevent="removeBookmark">
          <button
            class="question-controls__bookmark question-controls__bookmark--active"
            type="submit"
            :disabled="!permissions.canUnbookmark"
          >
            <i class="fas fa-bookmark"></i>
          </button>
        </form>
        <form v-else @submit.prevent="addBookmark">
          <button class="question-controls__bookmark" type="submit" :disabled="!permissions.canBookmark">
            <i class="far fa-bookmark"></i>
          </button>
        </form>
      </div>
      <question-card :question="question" :isTrashed="isTrashed" :permissions="permissions"></question-card>
    </div>
  </section>
</template>

<script>
import QuestionCard from '@/Components/Questions/Question'
import Votes from '@/Components/Questions/Votes'
import Alert from '@/Components/Alert'

export default {
  name: 'QuestionSection',
  components: { Alert, Votes, QuestionCard },
  props: {
    question: {
      type: Object,
      required: true,
    },
    isTrashed: {
      type: Boolean,
      required: true,
    },
    userQuestionVote: {
      type: Object,
      default: () => ({}),
    },
    bookmark: {
      type: Object,
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
      let voteSum = this.question.votes_sum_vote

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
    addBookmark() {
      this.$inertia.post(route('questions.bookmarks.store', this.question))
    },
    removeBookmark() {
      this.$inertia.delete(route('questions.bookmarks.destroy', [this.question, this.bookmark]))
    },
    addVote() {
      this.$inertia.post(route('questions.upvote', this.question))
    },
    removeVote() {
      this.$inertia.post(route('questions.downvote', this.question))
    },
  },
}
</script>
