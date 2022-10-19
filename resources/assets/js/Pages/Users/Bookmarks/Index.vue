<template>
  <div class="mx-auto mt-8 max-w-6xl px-4 xl:px-0">
    <h1 class="mb-4 text-xl font-semibold">Your bookmarks</h1>
    <div v-if="loadedQuestions.length" class="space-y-4">
      <QuestionsFeedCard
        v-for="bookmark in loadedQuestions"
        :key="bookmark.id"
        :question="bookmark"
        :id="`question-${bookmark.id}`"
      />
    </div>
    <template v-else>
      <p class="text-center">Questions you have bookmarked will appear here.</p>
    </template>
  </div>
</template>

<script>
import QuestionsFeedCard from '@/Components/QuestionsFeedCard'

export default {
  name: 'UserBookmarksIndexPage',
  components: { QuestionsFeedCard },
  props: {
    bookmarkedQuestions: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      loadedQuestions: this.bookmarkedQuestions.data,
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
  methods: {
    nextPage() {
      if (!this.bookmarkedQuestions.next_page_url || this.loading) {
        return
      }

      this.loading = true

      this.$inertia.visit(this.bookmarkedQuestions.next_page_url, {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => (this.loading = false),
      })
    },
    updateObserver() {
      this.observer.disconnect()

      if (this.loadedQuestions.length < 1 || !this.bookmarkedQuestions.next_page_url) {
        return
      }

      const lastQuestionId = `question-${this.loadedQuestions.slice(-1)[0].id}`
      this.observer.observe(document.getElementById(lastQuestionId))
    },
  },
}
</script>
