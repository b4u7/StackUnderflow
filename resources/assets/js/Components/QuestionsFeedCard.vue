<template>
  <div class="questions-feed__card" @click="onCardClick">
    <div class="questions-feed__card__header">
      <div class="questions-feed__card__user">
        <a :href="route('user.show', question.user)">
          <img
            :src="question.user.avatar"
            :alt="question.user.name"
            alt="'s Avatar"
            class="questions-feed__card__user__avatar"
          />
        </a>
        <div>
          <p>
            <a class="questions-feed__card__user__name" :href="route('user.show', question.user)">
              {{ question.user.name }}
            </a>
          </p>
          <p>
            {{ lastActionType + ' ' + lastActionTime.toRelative() }}
          </p>
        </div>
      </div>
    </div>
    <div class="questions-feed__card__body">
      <h1 class="questions-feed__card__title">
        <a :href="route('questions.show', question.id)">
          {{ question.title }}
        </a>
      </h1>
      <p class="questions-feed__card__content">
        {{ questionBody }}
      </p>
    </div>
    <div v-if="question.tags.length" class="questions-feed__card__tags">
      <a v-for="(tag, index) in question.tags" :key="index" href="#">
        <Tag :tag="tag"></Tag>
      </a>
    </div>
    <div class="questions-feed__card__footer">
      <div class="questions-feed__card__stats">
        <p><i class="fas fa-comment-alt"></i> {{ question.answers.length }}</p>
        <p :class="votesColour"><i class="fas fa-sort"></i> {{ question.votes_count }}</p>
        <p><i class="fas fa-eye"></i> {{ question.views_count }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import Tag from '@/Components/Tag'
import { DateTime } from 'luxon'
import { max } from 'lodash'

export default {
  name: 'QuestionsFeedCard',
  components: { Tag },
  props: {
    question: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      classes: {
        success: 'text-emerald-600',
        danger: 'text-red-600'
      }
    }
  },
  computed: {
    votesColour() {
      let voteCount = this.question.votes_count

      if (voteCount > 0) {
        return this.classes.success
      } else if (voteCount < 0) {
        return this.classes.danger
      }
    },
    lastAnswer() {
      return this.question.answers.slice(-1)
    },
    lastActionType() {
      if (this.lastAnswer?.created_at > this.question.updated_at) {
        return 'Answered'
      }

      if (this.question.created_at !== this.question.updated_at) {
        return 'Modified'
      }

      return 'Asked'
    },
    lastActionTime() {
      return max([this.question.created_at, this.question.updated_at].map(DateTime.fromISO))
    },
    questionBody() {
      let body = this.question.body
      if (body.length > 100) {
        body = body.substring(0, 100) + '...'
      }

      return body
    }
  },
  methods: {
    onCardClick() {
      this.$inertia.get(route('questions.show', this.question))
    }
  }
}
</script>
