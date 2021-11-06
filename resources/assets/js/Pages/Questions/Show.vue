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
        />
        <!-- TODO: Verify if permissions object is setup correctly -->
        <answers-section
          :answers="question.answers"
          :user-answer-votes="userAnswerVotes"
          :permissions="permissions.answers"
        />
        <!-- TODO: Don't show this if the user has already answered the question -->
        <form @submit.prevent="submitAnswer">
          <div class="form__group">
            <markdown-editor v-model="form.body" />
            <p
              v-if="errors.body"
              class="form__group__description form__group__description--error"
              v-text="errors.body"
            />
          </div>
          <div class="form__footer text-right">
            <button type="submit" class="button button--primary mb-4" :disabled="form.processing">
              Submit your answer
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
import QuestionSection from '@/Components/Questions/QuestionSection'
import AnswersSection from '@/Components/Questions/AnswersSection'
import MarkdownEditor from '@/Components/MarkdownEditor'

export default {
  name: 'Show',
  components: { MarkdownEditor, AnswersSection, QuestionSection },
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
    errors: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        body: '',
      }),
    }
  },
  methods: {
    submitAnswer() {
      this.form.post(this.route('answers.store', this.question))
    },
  },
}
</script>
