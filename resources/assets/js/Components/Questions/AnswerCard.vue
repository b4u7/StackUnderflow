<template>
  <Card
    :class="{ 'ring-green-500': !!this.isSolution, 'ring-red-500': this.isTrashed }"
    :id="`answer-${answer.id}`"
    class="w-full"
  >
    <template #body>
      <div class="py-3">
        <rendered-markdown :html="answer.html_body" />
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
          :edit-route="route('questions.answers.edit', [answer.question_id, answer])"
          :delete-route="route('questions.answers.destroy', [answer.question_id, answer])"
          :restore-route="route('questions.answers.restore', [answer.question_id, answer])"
          :share-url="shareUrl"
        />
        <div class="flex w-full flex-row space-x-2 text-sm text-slate-500 sm:ml-auto sm:w-auto sm:text-right">
          <div>
            <p>
              <a
                class="font-medium text-slate-900 hover:text-primary-700 hover:underline focus:text-primary-600 focus:underline active:text-primary-600 active:underline"
                :href="route('users.show', answer.user)"
              >
                {{ answer.user.name }}
              </a>
            </p>
            <p>
              Answered
              <format-date-time :value="answer.created_at" />
            </p>
          </div>
          <a :href="route('users.show', answer.user)" class="hidden sm:inline-block">
            <div class="h-10 w-10 overflow-hidden rounded-full ring-4 ring-white">
              <img :src="answer.user.avatar" :alt="answer.user.name" class="h-full w-full object-cover object-center" />
            </div>
          </a>
        </div>
      </div>
    </template>
  </Card>
</template>

<script>
import Card from '../Generic/Card.vue'
import FormatDateTime from '@/Components/FormatDateTime'
import FooterActions from '@/Components/Questions/Actions/FooterActions'
import RenderedMarkdown from '@/Components/Generic/RenderedMarkdown'

export default {
  name: 'AnswerCard',
  components: { Card, FooterActions, FormatDateTime, RenderedMarkdown },
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
    isTrashed: {
      type: Boolean,
      required: true,
    },
  },
  computed: {
    shareUrl() {
      return `${this.route('questions.show', [this.answer.question_id])}#answer-${this.answer.id}`
    },
  },
}
</script>

<style scoped></style>
