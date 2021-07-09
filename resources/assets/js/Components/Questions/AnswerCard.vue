<template>
  <div class="answer-card">
    <div class="answer-card__header"></div>
    <div class="answer-card__content">
      <div class="answer-card__body">
        <div v-html="answer.body"></div>
      </div>
    </div>
    <div class="answer-card__footer">
      <div class="answer-card__menu">
        <a> Share </a>
        <a v-if="permissions.canEdit" @submit.prevent="editAnswer"> Edit </a>
        <form v-if="permissions.canDelete" class="form" @submit.prevent="deleteAnswer">
          <a> Delete </a>
        </form>
      </div>
      <div class="answer-card__user">
        <div>
          <p>
            <a class="answer-card__user__name" :href="route('user.show', answer.user)">
              {{ answer.user.name }}
            </a>
          </p>
          <p>Asked {{ createdAt }}</p>
        </div>
        <a :href="route('user.show', answer.user)">
          <img :src="answer.user.avatar" :alt="answer.user.name" class="answer-card__user__avatar" />
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import { DateTime } from 'luxon'

export default {
  name: 'AnswerCard',
  props: {
    answer: {
      type: Object,
      required: true,
    },
    permissions: {
      type: Object,
      required: true,
    },
  },
  computed: {
    createdAt() {
      return DateTime.fromISO(this.answer.created_at).toLocaleString(DateTime.DATETIME_FULL)
    },
    voteColour() {},
  },
  methods: {
    editAnswer() {
      this.$inertia.post(route('answers.edit', [this.answer.question_id, this.answer]))
    },
    deleteAnswer() {
      this.$inertia.delete(route('answers.delete', [this.answer.question_id, this.answer]))
    },
  },
}
</script>

<style scoped></style>
