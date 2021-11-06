<template>
  <section class="section">
    <div v-if="isTrashed" class="alert alert--danger my-8">
      <p>
        <i class="fas fa-exclamation-triangle"></i>
        This question was deleted, only admins can see it.
      </p>
    </div>

    <!-- TODO: Clean up class bindings -->
    <div class="flex flex-row">
      <div class="question-controls">
        <form @submit.prevent="addVote">
          <button
            :class="userQuestionVote && userQuestionVote.vote === 1 ? 'question-controls__vote-up--active' : ''"
            :disabled="!permissions.canVote"
            class="question-controls__vote-up"
            type="submit"
          >
            <i class="fas fa-angle-up"></i>
          </button>
        </form>
        <p class="question-controls__vote-count">
          <span v-if="question.votes_sum_vote" :class="voteSumColour">
            {{ question.votes_sum_vote }}
          </span>
          <span v-else> 0 </span>
        </p>
        <form @submit.prevent="removeVote">
          <button
            :class="userQuestionVote && userQuestionVote.vote === -1 ? 'question-controls__vote-down--active' : ''"
            :disabled="!permissions.canVote"
            class="question-controls__vote-down"
            type="submit"
          >
            <i class="fas fa-angle-down"></i>
          </button>
        </form>
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
import QuestionCard from '@/Components/Questions/QuestionCard'

export default {
  name: 'QuestionSection',
  components: { QuestionCard },
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
        success: 'text-green-600',
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
