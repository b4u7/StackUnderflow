<template>
  <div :class="{ 'answer-card--trashed': isTrashed }" class="answer-card">
    <div class="answer-card__header"></div>
    <div class="answer-card__content">
      <div class="answer-card__body">
        <div v-html="answer.body" />
      </div>
    </div>
    <div class="answer-card__footer">
      <div class="answer-card__menu">
        <button type="button"><i class="fas fa-link"></i> Share</button>
        <form v-if="permissions.canEdit" @submit.prevent="editAnswer">
          <button type="submit">
            <i class="fas fa-edit"></i>
            Edit
          </button>
        </form>
        <form v-if="permissions.canDelete && !isTrashed" @submit.prevent="deleteAnswer">
          <button
            type="submit"
            class="text-red-600 hover:text-red-700 font-semibold active:text-red-500 focus:text-red-500"
          >
            <i class="fas fa-trash-alt"></i>
            Delete
          </button>
        </form>
        <form v-if="permissions.canRestore && isTrashed" @submit.prevent="restoreAnswer">
          <button type="submit">
            <i class="fas fa-trash-restore"></i>
            Restore
          </button>
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
  data() {
    return {
      isTrashed: !!this.answer.deleted_at,
    }
  },
  computed: {
    createdAt() {
      return DateTime.fromISO(this.answer.created_at).toLocaleString(DateTime.DATETIME_FULL)
    },
  },
  methods: {
    editAnswer() {
      this.$inertia.post(route('answers.edit', [this.answer.question_id, this.answer]))
    },
    deleteAnswer() {
      this.$inertia.delete(route('answers.destroy', [this.answer.question_id, this.answer]))
    },
    restoreAnswer() {
      this.$inertia.post(route('answers.restore', [this.answer.question_id, this.answer]))
    },
  },
}
</script>

<style scoped></style>
