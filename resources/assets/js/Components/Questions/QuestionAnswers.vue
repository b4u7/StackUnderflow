<template>
  <section class="section">
    <p class="mt-12 mb-4 text-slate-800 text-xl font-medium">
      <span>
        <font-awesome-icon icon="fa-solid fa-message" />
        {{ answers.length }}
      </span>
      {{ $tc('answer | answers', answers.length) }}
    </p>
    <answer-section
      v-for="answer in answers"
      :key="`${solutionId}:${answer.id}`"
      :answer="answer"
      :is-solution="answer.id === solutionId"
      :permissions="permissions[answer.id]"
    />
  </section>
</template>

<script>
import AnswerSection from './AnswerSection'

export default {
  name: 'QuestionAnswers',
  components: { AnswerSection },
  props: {
    questionId: {
      type: Number,
      required: true,
    },
    solutionId: {
      type: Number,
    },
    permissions: {
      type: Object,
      default: () => ({}),
    },
    answers: {
      type: Array,
      required: true,
    },
    nextPageUrl: {
      type: String,
    },
    prevPageUrl: {
      type: String,
    },
  },
  methods: {
    async nextPage() {
      this.$inertia.visit(this.nextPageUrl)
    },
    async prevPage() {
      this.$inertia.visit(this.prevPageUrl)
    },
  },
}
</script>
