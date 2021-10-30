<template>
  <div class="question-card">
    <div class="question-card__header">
      <h1 class="question-card__title">
        {{ question.title }}
      </h1>
      <div class="question-card__stats">
        <p>
          {{ lastActionType }}
          <span class="text-gray-700 font-medium">{{ lastActionRelativeTime }}</span>
        </p>
        <p>
          viewed
          <span class="text-gray-700 font-medium"> {{ question.views_count }} times </span>
        </p>
      </div>
    </div>
    <div class="question-card__content">
      <div class="question-card__body">
        <div v-html="question.body"></div>
      </div>
    </div>
    <div v-if="question.tags.length" class="question-card__tags">
      <div v-for="tag in question.tags" class="question-card__tag">
        {{ tag.name }}
      </div>
    </div>
    <div class="question-card__footer">
      <div class="question-card__menu">
        <a> Share </a>
        <a v-if="permissions.canEdit" @submit.prevent="editQuestion"> Edit </a>
        <form v-if="permissions.canDelete" class="form" @submit.prevent="deleteQuestion">
          <button type="submit">Delete</button>
        </form>
      </div>
      <div class="question-card__user">
        <div>
          <p>
            <a class="question-card__user__name" :href="route('user.show', question.user)">
              {{ question.user.name }}
            </a>
          </p>
          <p>Asked {{ createdAt }}</p>
        </div>
        <a :href="route('user.show', question.user)">
          <img :src="question.user.avatar" :alt="question.user.name" class="question-card__user__avatar" />
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import { DateTime } from 'luxon'

export default {
  name: 'QuestionCard',
  props: {
    question: {
      type: Object,
      required: true,
    },
    permissions: {
      type: Object,
      required: true,
    },
  },
  computed: {
    lastActionType() {
      let text = 'Asked'

      if (this.question.answers.length > 0 && this.question.answers.slice(-1).created_at > this.question.updated_at) {
        text = 'Answered'
      } else if (this.question.updated_at) {
        text = 'Modified'
      }

      return text
    },
    lastActionRelativeTime() {
      return DateTime.fromISO(this.question.created_at).toRelative().toString()
    },
    createdAt() {
      return DateTime.fromISO(this.question.created_at).toLocaleString(DateTime.DATETIME_FULL)
    },
    createdAtRelative() {
      return DateTime.fromISO(this.question.created_at).toRelative()
    },
  },
  methods: {
    editQuestion() {
      this.$inertia.post(route('questions.edit', this.question))
    },
    deleteQuestion() {
      this.$inertia.delete(route('questions.destroy', this.question))
    },
  },
}
</script>

<style scoped></style>
