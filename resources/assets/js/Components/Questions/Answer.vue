<template>
  <div :class="classes" :id="`answer-${answer.id}`" class="qa-card">
    <div class="qa-card__body py-3">
      <div class="qa-card__content">
        <rendered-markdown :html="answer.html_body" />
      </div>
    </div>
    <div class="qa-card__footer">
      <div class="qa-card__menu">
        <footer-actions
          :can-edit="permissions.canEdit"
          :can-delete="permissions.canDelete"
          :can-restore="permissions.canRestore"
          :is-trashed="isTrashed"
          :edit-route="route('questions.answers.edit', [answer.question_id, answer])"
          :delete-route="route('questions.answers.destroy', [answer.question_id, answer])"
          :restore-route="route('questions.answers.restore', [answer.question_id, answer])"
          :share-url="shareUrl"
        />
      </div>
      <div class="qa-card__user ml-auto text-right">
        <div>
          <p>
            <a class="qa-card__user__name" :href="route('user.show', answer.user)">
              {{ answer.user.name }}
            </a>
          </p>
          <p>
            Answered
            <format-date-time :value="answer.created_at" />
          </p>
        </div>
        <a :href="route('user.show', answer.user)">
          <img :src="answer.user.avatar" :alt="answer.user.name" class="qa-card__user__avatar" />
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import Tippy from '@/Components/Tippy'
import FormatDateTime from '@/Components/FormatDateTime'
import FooterActions from '@/Components/Questions/Actions/FooterActions'
import RenderedMarkdown from '@/Components/Generic/RenderedMarkdown'

export default {
  name: 'AnswerCard',
  components: { RenderedMarkdown, FooterActions, FormatDateTime, Tippy },
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
        'qa-card--solution': this.isSolution,
        'qa-card--trashed': this.isTrashed,
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
