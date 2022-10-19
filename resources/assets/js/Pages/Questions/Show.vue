<template>
  <div class="mx-auto mt-8 max-w-6xl px-4 xl:px-0">
    <div class="content">
      <Alert v-if="isTrashed" kind="danger" class="mb-12">
        <template #icon>
          <i class="fas fa-exclamation-triangle" />
        </template>
        <template #default>
          <p>This question was deleted, only admins can see it.</p>
        </template>
      </Alert>
      <div class="mr-0 mb-4 text-right">
        <a :href="route('questions.create')" class="button button--primary button--responsive">Ask question</a>
      </div>
      <QuestionSection
        :question="question"
        :is-trashed="isTrashed"
        :user-question-vote="userQuestionVote"
        :bookmarked="bookmarked"
        :permissions="permissions.question"
      />
      <QuestionAnswersSection
        :answers="answers.data"
        :next-page-url="answers.next_page_url"
        :prev-page-url="answers.prev_page_url"
        :question-id="question.id"
        :solution-id="question.solution_id"
        :permissions="permissions.answers"
      />
      <div v-if="canAnswer.allowed" class="mt-4">
        <h1 class="font-semibold">Write your own answer</h1>
        <form @submit.prevent="submitAnswer">
          <div :class="{ 'form__group--error': errors.body }" class="form__group">
            <markdown-editor :value="form.body" v-model="form.body" />
            <p v-if="errors.body" class="form__group__description" v-text="errors.body" />
          </div>
          <div class="form__footer text-right">
            <button class="button button--primary mb-4" type="submit" :disabled="form.processing">
              Submit your answer
            </button>
          </div>
        </form>
      </div>
      <p v-else-if="canAnswer.message" class="mt-8 text-center font-medium" v-text="canAnswer.message" />
    </div>
  </div>
</template>

<script>
import Alert from '@/Components/Alert'
import MarkdownEditor from '@/Components/Generic/MarkdownEditor'
import QuestionSection from '@/Components/Questions/QuestionSection'
import QuestionAnswersSection from '@/Components/Questions/QuestionAnswersSection'

export default {
  name: 'QuestionsShowPage',
  components: { Alert, MarkdownEditor, QuestionAnswersSection, QuestionSection },
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
    bookmarked: {
      type: Boolean,
      required: true,
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
      return this.permissions.question.canAnswer
    },
  },
  methods: {
    submitAnswer() {
      this.form.post(this.route('questions.answers.store', this.question))
    },
    addComment() {
      this.$inertia.post(route('questions.comment', this.question), null, {
        preserveScroll: true,
      })
    },
  },
}
</script>
