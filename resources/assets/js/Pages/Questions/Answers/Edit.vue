<template>
  <section class="section mt-8">
    <div class="container sm:max-w-screen-lg">
      <h1 class="text-2xl font-medium mb-4">Edit your answer</h1>
      <form class="form" @submit.prevent="submit">
        <div class="form__group">
          <label class="form__group__label"> Body </label>
          <markdown-editor :value="form.body" v-model="form.body" />
          <p v-if="errors.body" class="form__group__description form__group__description--error" v-text="errors.body" />
        </div>
        <div class="form__footer text-right">
          <button type="submit" class="button button--primary mb-4" :disabled="form.processing">Save edits</button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import MarkdownEditor from '@/Components/Generic/MarkdownEditor'

export default {
  name: 'Edit.vue',
  components: { MarkdownEditor },
  props: {
    answer: {
      type: Object,
      required: true,
    },
    errors: {
      type: Object,
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        title: this.answer.title,
        body: this.answer.body,
        tags: this.answer.tags,
      }),
    }
  },
  methods: {
    submit() {
      this.form.put(this.route('questions.answers.update', [this.answer.question_id, this.answer]))
    },
  },
}
</script>
