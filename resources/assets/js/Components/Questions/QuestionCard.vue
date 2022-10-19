<template>
  <Card :class="{ 'ring-red-500': isTrashed }" class="w-full">
    <template #header>
      <div class="flex flex-col p-4">
        <h1 class="text-2xl font-semibold text-slate-800" v-text="question.title" />
        <div class="flex flex-row space-x-2 text-sm text-slate-500">
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
    </template>
    <template #body>
      <div class="flex-grow py-2 text-slate-600">
        <RenderedMarkdown :html="question.html_body" />
      </div>
      <div v-if="question.tags.length" class="space-x-2 pt-4">
        <tag v-for="(tag, index) in question.tags" :key="index" :tag="tag" />
      </div>
    </template>
    <template #footer>
      <div
        class="flex flex-col items-start space-y-8 py-3 px-4 text-slate-500 sm:flex-row sm:items-center sm:space-y-0"
      >
        <footer-actions
          :can-edit="permissions.canEdit"
          :can-delete="permissions.canDelete"
          :can-restore="permissions.canRestore"
          :is-trashed="isTrashed"
          :edit-route="route('questions.edit', [question.id])"
          :delete-route="route('questions.destroy', [question.id])"
          :restore-route="route('questions.restore', [question.id])"
          :share-url="shareUrl"
        />
        <div class="flex w-full flex-row space-x-2 text-sm text-slate-500 sm:ml-auto sm:w-auto sm:text-right">
          <div>
            <p>
              <a
                class="font-medium text-slate-900 hover:text-primary-700 hover:underline focus:text-primary-600 focus:underline active:text-primary-600 active:underline"
                :href="route('users.show', question.user)"
              >
                {{ question.user.name }}
              </a>
            </p>
            <p>
              Asked
              <format-date-time :value="question.created_at" />
            </p>
          </div>
          <a :href="route('users.show', question.user)" class="hidden sm:inline-block">
            <div class="h-10 w-10 overflow-hidden rounded-full ring-4 ring-white">
              <img
                :src="question.user.avatar"
                :alt="question.user.name"
                class="h-full w-full object-cover object-center"
              />
            </div>
          </a>
        </div>
      </div>
    </template>
  </Card>
</template>

<script>
import { DateTime } from 'luxon'
import { max } from 'lodash'
import Card from '@/Components/Generic/Card.vue'
import FormatDateTime from '@/Components/FormatDateTime'
import FooterActions from '@/Components/Questions/Actions/FooterActions'
import RenderedMarkdown from '@/Components/Generic/RenderedMarkdown'
import Tag from '@/Components/Tag'

export default {
  name: 'QuestionCard',
  components: { Card, FormatDateTime, FooterActions, RenderedMarkdown, Tag },
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
      return this.question.created_at !== this.question.updated_at ? 'Modified' : 'Asked'
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
