<template>
  <div :class="{ 'question-card--trashed': isTrashed }" class="question-card">
    <div class="question-card__header">
      <h1 class="question-card__title">
        {{ question.title }}
      </h1>
      <div class="question-card__stats">
        <p>
          {{ lastActionType }}
          <span class="text-zinc-700 font-medium">{{ lastActionRelativeTime }}</span>
        </p>
        <p>
          viewed
          <span class="text-zinc-700 font-medium"> {{ question.views_count }} times </span>
        </p>
      </div>
    </div>
    <div class="question-card__content">
      <div class="question-card__body">
        <div v-html="question.body"></div>
      </div>
    </div>
    <div v-if="question.tags.length" class="question-card__tags">
      <Tag v-for="(tag, index) in question.tags" :key="index" :tag="tag"></Tag>
    </div>
    <div class="question-card__footer">
      <div class="question-card__menu">
        <button type="button"><i class="fas fa-link"></i> Share</button>
        <form v-if="permissions.canEdit" @submit.prevent="editAnswer">
          <button v-if="permissions.canEdit" @submit.prevent="editAnswer" type="submit">
            <i class="fas fa-edit"></i>Edit
          </button>
        </form>
        <form v-if="permissions.canDelete && !isTrashed" @submit.prevent="deleteAnswer">
          <button type="submit">
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
import Tag from '@/Components/Tag'

export default {
  name: 'QuestionCard',
  components: { Tag },
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
