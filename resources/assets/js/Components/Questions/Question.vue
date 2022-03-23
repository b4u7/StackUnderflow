<template>
  <div :class="{ 'question-card--trashed': isTrashed }" class="question-card">
    <div class="question-card__header">
      <h1 class="question-card__title" v-text="question.title" />
      <div class="question-card__stats">
        <p>
          {{ lastActionType }}
          <span class="text-zinc-700 font-medium">{{ lastActionTime.toRelative() }}</span>
        </p>
        <p>
          viewed
          <span class="text-zinc-700 font-medium"> {{ question.views_count }} times </span>
        </p>
      </div>
    </div>
    <div class="question-card__body">
      <div class="question-card__content">
        <div v-html="question.body" />
      </div>
    </div>
    <div v-if="question.tags.length" class="question-card__tags">
      <tag v-for="(tag, index) in question.tags" :key="index" :tag="tag" />
    </div>
    <div class="question-card__footer">
      <div class="question-card__menu">
        <footer-actions
          :can-edit="permissions.canEdit"
          :can-delete="permissions.canDelete"
          :can-restore="permissions.canRestore"
          :is-trashed="isTrashed"
          :edit-route="route('questions.edit', [this.question.id])"
          :delete-route="route('questions.destroy', [this.question.id])"
          :restore-route="route('questions.restore', [this.question.id])"
          :share-url="shareUrl"
        />
      </div>
      <div class="question-card__user">
        <div>
          <p>
            <a class="question-card__user__name" :href="route('user.show', question.user)">
              {{ question.user.name }}
            </a>
          </p>
          <p>
            Asked
            <format-date-time :value="question.created_at" />
          </p>
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
import Tag from '@/Components/Tag'
import FormatDateTime from '@/Components/FormatDateTime'
import { max } from 'lodash'
import FooterActions from '@/Components/Questions/Actions/FooterActions'

export default {
  name: 'QuestionCard',
  components: { FooterActions, FormatDateTime, Tag },
  props: {
    question: {
      type: Object,
      required: true,
    },
    isTrashed: {
      type: Boolean,
      required: true,
    },
    permissions: {
      // type: Object,
      required: true,
    },
  },
  computed: {
    lastActionType() {
      if (this.question.updated_at) {
        return 'Modified'
      }

      return 'Asked'
    },
    lastActionTime() {
      return max([this.question.created_at, this.question.updated_at].map(DateTime.fromISO))
    },
    shareUrl() {
      return window.location.href
    },
  },
}
</script>

<style scoped></style>
