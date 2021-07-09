<template>
  <section>
    <p class="mt-12 mb-4 text-gray-800 text-xl font-medium">
      <i class="fas fa-comment-alt"></i> {{ answers.length }}
      {{ $tc('answer | answers', answers.length) }}
    </p>

    <answer-section
      v-for="answer in answers"
      :key="answer.id"
      :answer="answer"
      :permissions="permissions[answer.id]"
      :user-answer-vote="userAnswerVotes[answer.id]"
    ></answer-section>
  </section>
</template>

<script>
import AnswerCard from './AnswerCard'
import AnswerSection from './AnswerSection'

export default {
  name: 'AnswersSection',
  components: { AnswerSection, AnswerCard },
  props: {
    answers: {
      type: Array,
      required: true,
    },
    permissions: {
      type: Object,
      required: true,
    },
    userAnswerVotes: {
      type: Object,
      required: true,
    },
  },
}
</script>

<style scoped></style>
