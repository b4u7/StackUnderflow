<template>
  <section>
    <alert v-if="isTrashed" kind="danger" class="my-8">
      <i class="fas fa-exclamation-triangle"></i>
      This question was deleted, only admins can see it.
    </alert>
    <div class="flex flex-row">
      <div class="actions">
        <votes
          :total-votes="question.votes_sum_vote || 0"
          :can-vote="permissions.canVote"
          :user-vote="userVote"
          @upvoted="addVote"
          @downvoted="removeVote"
        />
        <bookmark
          :active="!!bookmark"
          :can-bookmark="permissions.canBookmark"
          :can-unbookmark="permissions.canUnbookmark"
          @bookmark="bookmarkAction"
        />
      </div>
      <question-card :question="question" :isTrashed="isTrashed" :permissions="permissions" />
    </div>
  </section>
</template>

<script>
import QuestionCard from '@/Components/Questions/Question'
import Votes from '@/Components/Questions/Actions/Votes'
import Alert from '@/Components/Alert'
import Bookmark from '@/Components/Questions/Actions/Bookmark'

export default {
  name: 'QuestionSection',
  components: { Bookmark, Alert, Votes, QuestionCard },
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
    bookmarkAction(value) {
      console.log('bookmarkAction')
      value ? this.addBookmark() : this.removeBookmark()
    },
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
