<!-- TODO: Fix card height (make the content stretch) -->
<template>
  <section class="section">
    <div class="container">
      <div class="content">
        <div class="mr-0 mb-4 text-right">
          <a class="button button--fullwidth-touch" :href="route('questions.show', question.id)"> Go back </a>
        </div>

        <question-section
          :question="question"
          :is-trashed="isTrashed"
          :user-question-vote="userQuestionVote"
          :bookmark="bookmark"
          :permissions="permissions.question"
        >
        </question-section>

        <answers-section
          :answers="question.answers"
          :user-answer-votes="userAnswerVotes"
          :permissions="permissions.answers"
        >
        </answers-section>
      </div>
    </div>
  </section>
</template>

<script>
import QuestionSection from '@/Components/Questions/QuestionSection'
import AnswersSection from '@/Components/Questions/AnswersSection'

export default {
  name: 'Show',
  components: { AnswersSection, QuestionSection },
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
    userAnswerVotes: {
      type: Object,
      required: true,
    },
    bookmark: {
      type: Object,
    },
    permissions: {
      type: Object,
      required: true,
    },
  },
}
</script>
