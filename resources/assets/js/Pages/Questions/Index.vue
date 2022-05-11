<template>
  <section class="section mt-8">
    <div class="container">
      <div class="mr-0 mb-4 text-right">
        <a :href="route('questions.create')" class="button button--primary button--responsive"> Ask question </a>
      </div>
      <!-- TODO: Left sidebar with some question categories -->
      <div id="questions" class="questions-feed">
        <questions-feed-card
          v-for="question in loadedQuestions"
          :key="question.id"
          :question="question"
          :id="`question-${question.id}`"
        />
      </div>
    </div>
  </section>
</template>

<script>
import QuestionsFeedCard from '@/Components/QuestionsFeedCard'
import Tags from '@/Components/Tags'

export default {
  name: 'Index',
  components: { Tags, QuestionsFeedCard },
  props: {
    questions: {
      type: Object,
      required: true,
    },
    tags: {
      type: Array,
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
      this.observer.disconnect()

      if (this.loadedQuestions.length < 1 || !this.questions.next_page_url) {
        return
      }

      const lastQuestionId = `question-${this.loadedQuestions.slice(-1)[0].id}`
      this.observer.observe(document.getElementById(lastQuestionId))
    },
  },
}
</script>
