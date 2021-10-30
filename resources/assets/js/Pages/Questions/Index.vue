<template>
  <section class="section">
    <div class="container">
      <div class="mr-0 mb-4 text-right">
        <a class="button button--primary button--fullwidth-touch" :href="route('questions.create')"> Ask question </a>
      </div>
      <!-- TODO: Left sidebar with some question categories -->
      <div class="questions-feed mt-8" id="questions">
        <questions-feed-card
          v-for="question in loadedQuestions"
          :key="question.id"
          :question="question"
          :id="`question-${question.id}`"
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
  data() {
    return {
      loadedQuestions: this.questions.data,
      loading: false,
      observer: null,
    }
  },
  mounted() {
    this.observer = new IntersectionObserver(entries => {
      const intersecting = entries.some(entry => entry.intersectionRatio > 0)

      if (intersecting) {
        this.nextPage()
      }
    })

    this.$nextTick(() => this.updateObserver())
  },
  watch: {
    questions({ data }) {
      this.loadedQuestions.push.apply(this.loadedQuestions, data)
    },
    loadedQuestions() {
      this.$nextTick(() => this.updateObserver())
    },
  },
  methods: {
    nextPage() {
      if (!this.questions.next_page_url || this.loading) {
        return
      }

      this.loading = true

      this.$inertia.visit(this.questions.next_page_url, {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => (this.loading = false),
      })
    },
    updateObserver() {
      console.log('updateObserver')
      this.observer.disconnect()
      if (this.loadedQuestions.length < 1 || !this.questions.next_page_url) {
        return
      }

      const lastQuestionId = `question-${this.loadedQuestions.slice(-1)[0].id}`
      console.log(lastQuestionId)

      this.observer.observe(document.getElementById(lastQuestionId))
    },
  },
}
</script>
