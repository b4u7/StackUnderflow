<template>
  <div>
    <div
      :class="{ 'h-32 max-h-32 bg-slate-200': !user.header }"
      class="relative flex h-64 max-h-64 items-center justify-center overflow-hidden bg-slate-100"
    >
      <img
        v-if="user.header"
        :src="user.header"
        class="h-full w-full object-cover object-center"
        alt="Your header background"
      />
    </div>
    <div class="container py-4">
      <div class="md:grid md:grid-cols-12 md:gap-4">
        <div class="md:col-span-3">
          <div
            class="relative z-10 -mt-20 flex h-32 w-32 items-center justify-center overflow-hidden rounded-full border-4 border-slate-100"
          >
            <img :src="user.avatar" alt="Your user avatar" />
          </div>
          <h1 class="mt-2 text-2xl font-semibold text-slate-700" v-text="user.name" />
          <p class="font-medium text-slate-600" v-text="`@${user.username}`" />
          <p v-if="user.biography" class="mt-4 text-slate-700" v-text="user.biography" />
          <a
            v-if="canEdit"
            class="button button--primary button--fullwidth mt-4"
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
          <p v-if="user.company" class="mt-4 text-slate-800">
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
                  <Card
                    v-for="question in questions.data"
                    :key="question.id"
                    class="group hover:cursor-pointer hover:ring-primary-500"
                    @click.prevent="visitQuestion(question.id)"
                  >
                    <template #header>
                      <div class="py-3 px-4">
                        <h1 class="font-semibold text-slate-800 group-hover:text-primary-700">
                          {{ question.title }}
                        </h1>
                      </div>
                    </template>
                  </Card>
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
                  <Card
                    v-for="answer in answers.data"
                    class="group w-full hover:cursor-pointer hover:ring-primary-500"
                    :key="answer.id"
                    @click.prevent="visitAnswer(answer.question_id, answer.id)"
                  >
                    <template #body>
                      <div class="py-3">
                        <h1 class="font-semibold text-slate-800 group-hover:text-primary-700">
                          {{ answer.question.title }}
                        </h1>
                        <p>
                          {{ answer.body }}
                        </p>
                      </div>
                    </template>
                  </Card>
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
  </div>
</template>

<script>
import Tabs from '@/Components/Generic/Tabs'
import EditProfileModal from '@/Components/Users/EditProfileModal'
import Card from '../../Components/Generic/Card.vue'

export default {
  name: 'UserShowPage',
  components: { EditProfileModal, Tabs, Card },
  props: {
    answers: {
      type: Object,
      required: true,
    },
    canEdit: {
      type: Boolean,
      required: true,
    },
    questions: {
      type: Object,
      required: true,
    },
    user: {
      type: Object,
      required: true,
    },
    errors: {
      type: Object,
    },
  },
  data() {
    return {
      loadedData: {},
      loading: false,
      tabs: [
        { name: 'Questions', key: 'questions' },
        { name: 'Answers', key: 'answers' },
      ],
      editModalVisible: false,
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
        onFinish: () => (this.loading = false),
      })

      // this.loadedData.push(data)
    },
    visitQuestion(questionId) {
      this.$inertia.visit(`${this.route('questions.show', [questionId])}`)
    },
    visitAnswer(questionId, answerId) {
      this.$inertia.visit(`${this.route('questions.show', [questionId])}#answer-${answerId}`)
    },
  },
}
</script>
