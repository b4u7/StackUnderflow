<template>
  <Card
    :class="{ 'ring-red-500': question.deleted_at }"
    class="group w-full hover:cursor-pointer hover:ring-primary-500"
    @click="onCardClick"
  >
    <template #header>
      <div class="flex flex-col p-4">
        <div class="flex flex-row space-x-2 text-sm text-slate-500">
          <a :href="route('users.show', question.user)">
            <div class="h-10 w-10 overflow-hidden rounded-full ring-4 ring-white">
              <img
                :src="question.user.avatar"
                :alt="`${question.user.name} avatar`"
                class="h-full w-full object-cover object-center"
              />
            </div>
          </a>
          <div class="ml-2">
            <p
              class="font-medium text-slate-900 hover:text-primary-700 hover:underline focus:text-primary-600 focus:underline active:text-primary-600 active:underline"
            >
              <a :href="route('users.show', question.user)" v-text="question.user.name" />
            </p>
            <p v-text="lastActionType + ' ' + lastActionTime.toRelative()" />
          </div>
        </div>
      </div>
    </template>
    <template #body>
      <h1 class="mt-2 mb-3 text-2xl font-semibold text-slate-800 group-hover:text-primary-700">
        <a :href="route('questions.show', question.id)" v-text="question.title" />
      </h1>
      <p class="py-2 text-slate-600" v-html="questionBody" />
      <div v-if="question.tags.length" class="flex space-x-2 pt-4">
        <a v-for="(tag, index) in question.tags" :key="index" href="#">
          <tag :tag="tag" />
        </a>
      </div>
    </template>
    <template #footer>
      <div
        class="flex flex-col items-start space-y-8 space-x-4 py-3 px-4 text-slate-500 sm:flex-row sm:items-center sm:space-y-0"
      >
        <div class="flex flex-row space-x-4 text-slate-700">
          <p>
            <font-awesome-icon icon="fa-solid fa-message" />
            {{ question.answers.length }}
          </p>
          <p :class="votesColour">
            <font-awesome-icon icon="fa-solid fa-sort" />
            {{ question.votes_sum_vote ? question.votes_sum_vote : 0 }}
          </p>
          <p>
            <font-awesome-icon icon="fa-solid fa-eye" />
            {{ question.views_count }}
          </p>
        </div>
      </div>
    </template>
  </Card>
</template>

<script>
import { DateTime } from 'luxon'
import { max } from 'lodash'
import Card from '@/Components/Generic/Card'
import Tag from '@/Components/Tag'

export default {
  name: 'QuestionsFeedCard',
  components: { Card, Tag },
  props: {
    question: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      classes: {
        success: 'text-emerald-600',
        danger: 'text-red-600',
      },
    }
  },
  computed: {
    votesColour() {
      let votesSumVote = this.question.votes_sum_vote

      if (votesSumVote > 0) {
        return this.classes.success
      } else if (votesSumVote < 0) {
        return this.classes.danger
      }

      return ''
    },
    lastAnswer() {
      return this.question.answers.slice(-1)
    },
    lastActionType() {
      if (this.lastAnswer?.created_at > this.question.updated_at) {
        return 'Answered'
      }

      if (this.question.created_at !== this.question.updated_at) {
        return 'Modified'
      }

      return 'Asked'
    },
    lastActionTime() {
      return max([this.question.created_at, this.question.updated_at].map(DateTime.fromISO))
    },
    questionBody() {
      let body = this.question.stripped_body
      if (body.length > 100) {
        body = body.substring(0, 100) + '...'
      }

      return body
    },
  },
  methods: {
    onCardClick() {
      this.$inertia.get(route('questions.show', this.question))
    },
  },
}
</script>
