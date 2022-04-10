<template>
  <div class="user-profile">
    <header class="user-profile__header">
      <figure>
        <img :src="user.avatar" :alt="`${user.name}'s header background`" class="user-profile__header__background" />
      </figure>
    </header>
    <section class="section">
      <div class="container">
        <div class="md:grid md:grid-cols-12 md:gap-4">
          <div class="md:col-span-3">
            <figure>
              <img :src="user.avatar" :alt="`${user.name}'s avatar`" class="user-profile__avatar" />
            </figure>
            <h1 class="user-profile__name" v-text="user.name" />
            <p class="user-profile__username">@{{ user.username }}</p>
            <p class="user-profile__bio">
              {{ user.biography }}
            </p>
          </div>
          <div class="md:col-span-9">
            <tabs :tabs="tabs">
              <template #questions>
                <div class="mt-4 space-y-4">
                  <div v-for="question in questions.data" class="qa-card qa-card--hoverable">
                    <div class="qa-card__header">
                      <h1 class="qa-card__title">
                        {{ question.title }}
                      </h1>
                    </div>
                  </div>
                </div>
                <button class="button button--primary button--outline button--fullwidth-touch mt-4 ml-auto">
                  Load more
                </button>
              </template>
              <template #answers>
                <div class="mt-4 space-y-4">
                  <div v-for="answer in answers.data" class="qa-card qa-card--hoverable">
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

export default {
  name: 'Index',
  components: { Tabs },
  props: {
    user: {
      type: Object,
      required: true,
    },
    questions: {
      type: Object,
      required: true,
    },
    answers: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      loadedData: [],
      tabs: [
        { name: 'Questions', key: 'questions' },
        { name: 'Answers', key: 'answers' },
      ],
    }
  },
  methods: {
    nextPage() {
      // loadedData.push(data)
    },
  },
}
</script>
