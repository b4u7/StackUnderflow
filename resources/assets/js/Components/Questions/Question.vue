<template>
  <div :class="{ 'qa-card--trashed': isTrashed }" class="qa-card">
    <div class="qa-card__header">
      <h1 class="qa-card__title" v-text="question.title" />
      <div class="qa-card__metadata">
        <p>
          {{ lastActionType }}
          <span class="font-medium text-slate-700" v-text="lastActionTime.toRelative()" />
        </p>
        <p>
          viewed
          <span class="font-medium text-slate-700"> {{ question.views_count }} times </span>
        </p>
      </div>
    </div>
    <div class="qa-card__body">
      <div class="qa-card__content">
        <rendered-markdown :html="question.html_body" />
      </div>
    </div>
    <div v-if="question.tags.length" class="qa-card__tags">
      <tag v-for="(tag, index) in question.tags" :key="index" :tag="tag" />
    </div>
    <div class="qa-card__footer">
      <footer-actions
        :can-edit="permissions.canEdit"
        :can-delete="permissions.canDelete"
        :can-restore="permissions.canRestore"
        :is-trashed="isTrashed"
        :edit-route="route('questions.edit', [this.question.id])"
        :delete-route="route('questions.destroy', [this.question.id])"
        :restore-route="route('questions.restore', [this.question.id])"
        :share-url="shareUrl"
        class="qa-card__menu"
      />
      <div class="qa-card__user w-full sm:ml-auto sm:w-auto sm:text-right">
        <div>
          <p>
            <a class="qa-card__user__name" :href="route('users.show', question.user)">
              {{ question.user.name }}
            </a>
          </p>
          <p>
            Asked
            <format-date-time :value="question.created_at" />
          </p>
        </div>
        <a :href="route('users.show', question.user)" class="hidden sm:inline-block">
          <div class="qa-card__user__avatar">
            <img :src="question.user.avatar" :alt="question.user.name" />
          </div>
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
import RenderedMarkdown from '@/Components/Generic/RenderedMarkdown'

export default {
  name: 'QuestionCard',
  components: { RenderedMarkdown, FooterActions, FormatDateTime, Tag },
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
      if (this.question.created_at !== this.question.updated_at) {
        return 'Modified'
      }

      return 'Asked'
    },
    lastActionTime() {
      return max([this.question.created_at, this.question.updated_at].map(DateTime.fromISO))
    },
    shareUrl() {
      return this.route('questions.show', this.question.id)
    },
  },
}
</script>

<style scoped></style>
