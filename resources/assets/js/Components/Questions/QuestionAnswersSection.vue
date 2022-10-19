<template>
  <div>
    <p class="mt-12 mb-4 text-xl font-medium text-slate-800">
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
  </div>
</template>

<script>
import AnswerSection from './AnswerSection'

export default {
  name: 'QuestionAnswersSection',
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
