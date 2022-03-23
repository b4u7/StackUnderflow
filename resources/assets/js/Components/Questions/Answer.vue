<template>
  <div :class="classes" :id="`answer-${this.answer.id}`" class="answer-card">
    <div class="answer-card__header"></div>
    <div class="answer-card__body">
      <div class="answer-card__content">
        <div v-html="answer.body" />
      </div>
    </div>
    <div class="answer-card__footer">
      <div class="answer-card__menu">
        <footer-actions
          :can-edit="permissions.canEdit"
          :can-delete="permissions.canDelete"
          :can-restore="permissions.canRestore"
          :is-trashed="isTrashed"
          :edit-route="route('questions.answers.edit', [this.answer.question_id, this.answer])"
          :delete-route="route('questions.answers.destroy', [this.answer.question_id, this.answer])"
          :restore-route="route('questions.answers.restore', [this.answer.question_id, this.answer])"
          :share-url="shareUrl"
        />
      </div>
      <div class="answer-card__user">
        <div>
          <p>
            <a class="answer-card__user__name" :href="route('user.show', answer.user)">
              {{ answer.user.name }}
            </a>
          </p>
          <p>
            Answered
            <format-date-time :value="answer.created_at" />
          </p>
        </div>
        <a :href="route('user.show', answer.user)">
          <img :src="answer.user.avatar" :alt="answer.user.name" class="answer-card__user__avatar" />
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import Tippy from '@/Components/Tippy'
import FormatDateTime from '@/Components/FormatDateTime'
import FooterActions from '@/Components/Questions/Actions/FooterActions'

export default {
  name: 'AnswerCard',
  components: { FooterActions, FormatDateTime, Tippy },
  props: {
    answer: {
      type: Object,
      required: true,
    },
    isSolution: {
      type: Boolean,
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
      classes: {
        'answer-card--solution': this.isSolution,
        'answer-card--trashed': this.isTrashed,
      },
    }
  },
  computed: {
    shareUrl() {
      return `${window.location.href}#${this.answer.id}`
    },
  },
}
</script>

<style scoped></style>
