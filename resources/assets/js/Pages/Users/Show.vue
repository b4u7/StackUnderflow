<template>
  <div class="user-profile">
    <header :class="{ 'user-profile__header--empty': !user.header }" class="user-profile__header">
      <img
        v-if="user.header"
        :src="user.header"
        class="user-profile__header__background"
        alt="Your header background"
      />
    </header>
    <section class="section">
      <div class="container">
        <div class="md:grid md:grid-cols-12 md:gap-4">
          <div class="md:col-span-3">
            <div class="user-profile__avatar">
              <img :src="user.avatar" alt="Your user avatar" />
            </div>
            <h1 class="user-profile__name" v-text="user.name" />
            <p class="user-profile__username" v-text="`@${user.username}`" />
            <p v-if="user.biography" class="user-profile__bio" v-text="user.biography" />
            <a
              v-if="canEdit"
              class="mt-4 button button--primary button--fullwidth"
              :href="route('users.edit', user.id)"
              @click.prevent="editModalVisible = true"
            >
              Edit your profile
            </a>
            <edit-profile-modal :user="user" :errors="errors" v-model="editModalVisible" />
            <!-- TODO: Following & followers feature
            <div class="user-profile__social">
              <p>

              </p>
            </div>
            -->
            <p v-if="user.company" class="user-profile__company">
              <span class="mr-2">
                <font-awesome-icon icon="fa-solid fa-building" />
              </span>
              {{ user.company }}
            </p>
          </div>
          <div class="md:col-span-1"></div>
          <div class="md:col-span-8">
            <tabs :tabs="tabs">
              <template #questions>
                <div class="mt-4 space-y-4">
                  <template v-if="questions.data.length">
                    <div
                      v-for="question in questions.data"
                      class="qa-card qa-card--hoverable"
                      @click.prevent="visitQuestion(question.id)"
                    >
                      <div class="qa-card__header">
                        <h1 class="qa-card__title !text-base">
                          {{ question.title }}
                        </h1>
                      </div>
                    </div>
                    <button
                      v-if="questions.next_page_url"
                      class="button button--primary button--outline button--responsive mt-4 ml-auto"
                      @click.prevent="nextPage(questions.next_page_url)"
                    >
                      Next page
                    </button>
                  </template>
                  <template v-else>
                    <p class="text-center">This user hasn't asked anything.</p>
                  </template>
                </div>
              </template>
              <template #answers>
                <div class="mt-4 space-y-4">
                  <template v-if="answers.data.length">
                    <div
                      v-for="answer in answers.data"
                      class="qa-card qa-card--hoverable"
                      @click.prevent="visitAnswer(answer.question_id, answer.id)"
                    >
                      <div class="qa-card__header">
                        <h1 class="qa-card__title">
                          {{ answer.question.title }}
                        </h1>
                      </div>
                      <div class="qa-card__body">
                        {{ answer.body }}
                      </div>
                      <div class="qa-card__footer"></div>
                    </div>
                    <button
                      v-if="answers.next_page_url"
                      class="button button--primary button--outline button--responsive mt-4 ml-auto"
                      @click.prevent="nextPage(answers.next_page_url)"
                    >
                      Next page
                    </button>
                  </template>
                  <template v-else>
                    <p class="text-center">This user hasn't answered any questions.</p>
                  </template>
                </div>
              </template>
            </tabs>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Tabs from '@/Components/Generic/Tabs'
import EditProfileModal from '@/Components/Users/EditProfileModal'

export default {
  name: 'Show',
  components: { EditProfileModal, Tabs },
  props: {
    answers: {
      type: Object,
      required: true
    },
    canEdit: {
      type: Boolean,
      required: true
    },
    questions: {
      type: Object,
      required: true
    },
    user: {
      type: Object,
      required: true
    },
    errors: {
      type: Object
    }
  },
  created() {
    // TODO: Remove
    console.log(this.questions, this.questions.data)
  },
  data() {
    return {
      loadedData: {},
      loading: false,
      tabs: [
        { name: 'Questions', key: 'questions' },
        { name: 'Answers', key: 'answers' }
      ],
      editModalVisible: false
    }
  },
  methods: {
    // TODO: Infinite pagination
    nextPage(url) {
      if (!url || this.loading) {
        return
      }

      this.loading = true

      this.$inertia.visit(url, {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => (this.loading = false)
      })

      // this.loadedData.push(data)
    },
    visitQuestion(questionId) {
      this.$inertia.visit(`${this.route('questions.show', [questionId])}`)
    },
    visitAnswer(questionId, answerId) {
      this.$inertia.visit(`${this.route('questions.show', [questionId])}#answer-${answerId}`)
    }
  }
}
</script>
