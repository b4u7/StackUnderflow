<template>
  <div class="mx-auto mt-8 max-w-6xl px-4 xl:px-0">
    <div class="mr-0 mb-4 text-right">
      <a :href="route('questions.create')" class="button button--primary button--responsive">Ask question</a>
    </div>
    <!-- TODO: Left sidebar with some question categories -->
    <div id="questions" class="space-y-4">
      <QuestionsFeedCard
        v-for="question in loadedQuestions"
        :key="question.id"
        :question="question"
        :id="`question-${question.id}`"
      />
    </div>
    <div class="py-8 text-center">
      <p v-if="loading" class="text-4xl">
        <font-awesome-icon icon="fa-solid fa-spinner" class="animate-spin" />
      </p>
      <p v-else>
        You've reached the end. Consider
        <Link class="font-medium hover:text-primary-700" :href="route('questions.create')">
          <span class="underline">asking a question</span>
        </Link>
        to make the list longer.
      </p>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import QuestionsFeedCard from '@/Components/QuestionsFeedCard'

export default {
  name: 'QuestionsIndexPage',
  components: { Link, QuestionsFeedCard },
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
      sortBy: null,
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
