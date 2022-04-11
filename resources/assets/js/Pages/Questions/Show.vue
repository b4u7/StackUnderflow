<template>
  <section class="section">
    <div class="container sm:max-w-screen-xl">
      <div class="content">
        <alert v-if="isTrashed" kind="danger" class="mb-12">
          <i class="fas fa-exclamation-triangle"></i>
          This question was deleted, only admins can see it.
        </alert>
        <div class="mr-0 mb-4 text-right">
          <a class="button button--primary button--outline" :href="route('home')"> Go back </a>
        </div>
        <question-section
          :question="question"
          :is-trashed="isTrashed"
          :user-question-vote="userQuestionVote"
          :bookmark="bookmark"
          :permissions="permissions.question"
        />
        <question-answers
          :answers="answers.data"
          :next-page-url="answers.next_page_url"
          :prev-page-url="answers.prev_page_url"
          :question-id="question.id"
          :solution-id="question.solution_id"
          :permissions="permissions.answers"
        />
        <form v-if="canAnswer" @submit.prevent="submitAnswer">
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
import QuestionAnswers from '@/Components/Questions/QuestionAnswers'
import MarkdownEditor from '@/Components/Generic/MarkdownEditor'
import Tippy from '@/Components/Tippy'
import Alert from '@/Components/Alert'

export default {
  name: 'Show',
  components: { Alert, QuestionAnswers, Tippy, MarkdownEditor, QuestionSection },
  props: {
    question: {
      type: Object,
      required: true,
    },
    answers: {
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
    userAnswered: {
      type: Boolean,
      required: true,
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
  computed: {
    user() {
      return this.$page.props.auth.user ?? null
    },
    canAnswer() {
      return this.user && !this.userAnswered
    },
  },
  methods: {
    submitAnswer() {
      this.form.post(this.route('questions.answers.store', this.question))
    },
  },
}
</script>
