<template>
  <section class="section">
    <div class="container">
      <div class="mr-0 mb-4 text-right">
        <a class="button button--primary button--fullwidth-touch" :href="route('questions.create')"> Ask question </a>
      </div>
      <!-- TODO: Left sidebar with some question categories -->
      <div class="questions-feed mt-8">
        <questions-feed-card
          v-for="question in questions.data"
          :key="question.id"
          :question="question"
        ></questions-feed-card>
      </div>
    </div>
  </section>
</template>

<script>
import QuestionsFeedCard from '@/Components/QuestionsFeedCard'

export default {
  name: 'Index',
  components: { QuestionsFeedCard },
  props: {
    questions: {
      type: Object,
      required: true,
    },
  },
  computed: {},
}
</script>
