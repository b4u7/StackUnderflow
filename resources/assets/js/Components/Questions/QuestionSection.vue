<template>
  <div class="flex flex-row">
    <div class="pr-8 text-center font-semibold">
      <Votes
        :total-votes="question.votes_sum_vote || 0"
        :can-vote="permissions.canVote"
        :user-vote="userVote"
        @upvoted="addVote"
        @downvoted="removeVote"
      />
      <Bookmark
        :bookmarked="bookmarked"
        :can-bookmark="permissions.canBookmark"
        :can-unbookmark="permissions.canUnbookmark"
        @bookmark="bookmarkAction"
      />
    </div>
    <QuestionCard :question="question" :isTrashed="isTrashed" :permissions="permissions" />
  </div>
</template>

<script>
import Bookmark from '@/Components/Questions/Bookmark'
import QuestionCard from '@/Components/Questions/QuestionCard'
import Votes from '@/Components/Questions/Actions/Votes'

export default {
  name: 'QuestionSection',
  components: { Bookmark, QuestionCard, Votes },
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
    bookmarked: {
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
      let voteSum = this.question.votes_sum_vote

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
    bookmarkAction(value) {
      value ? this.removeBookmark() : this.addBookmark()
    },
    addBookmark() {
      this.$inertia.post(route('questions.bookmark', this.question), null, {
        preserveScroll: true,
      })
    },
    removeBookmark() {
      this.$inertia.post(route('questions.unbookmark', this.question), null, {
        preserveScroll: true,
      })
    },
    addVote() {
      this.$inertia.post(route('questions.upvote', this.question), null, {
        preserveScroll: true,
      })
    },
    removeVote() {
      this.$inertia.post(route('questions.downvote', this.question), null, {
        preserveScroll: true,
      })
    },
  },
}
</script>
