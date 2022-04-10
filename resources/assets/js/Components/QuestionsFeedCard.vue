<template>
  <div class="qa-card qa-card--hoverable" @click="onCardClick">
    <div class="qa-card__header">
      <div class="qa-card__user">
        <a :href="route('user.show', question.user)">
          <img :src="question.user.avatar" :alt="`${question.user.name} avatar`" class="qa-card__user__avatar" />
        </a>
        <div class="ml-2">
          <a class="qa-card__user__name" :href="route('user.show', question.user)">
            <p v-text="question.user.name" />
          </a>
          <p v-text="lastActionType + ' ' + lastActionTime.toRelative()" />
        </div>
      </div>
    </div>
    <div class="qa-card__body">
      <a :href="route('questions.show', question.id)">
        <h1 class="qa-card__title mt-2 mb-3" v-text="question.title" />
      </a>
      <p class="qa-card__content" v-html="questionBody" />
    </div>
    <div v-if="question.tags.length" class="qa-card__tags">
      <a v-for="(tag, index) in question.tags" :key="index" href="#">
        <tag :tag="tag" />
      </a>
    </div>
    <div class="qa-card__footer">
      <div class="qa-card__stats">
        <p>
          <font-awesome-icon icon="fa-solid fa-message" />
          {{ question.answers.length }}
        </p>
        <p :class="votesColour">
          <font-awesome-icon icon="fa-solid fa-sort" />
          {{ question.votes_count }}
        </p>
        <p>
          <font-awesome-icon icon="fa-solid fa-eye" />
          {{ question.views_count }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import Tag from '@/Components/Tag'
import { DateTime } from 'luxon'
import { max } from 'lodash'

export default {
  name: 'QuestionsFeedCard',
  components: { Tag },
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
      let voteCount = this.question.votes_count

      if (voteCount > 0) {
        return this.classes.success
      } else if (voteCount < 0) {
        return this.classes.danger
      }
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
