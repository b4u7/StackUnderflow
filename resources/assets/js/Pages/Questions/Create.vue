<template>
  <section class="section mt-8">
    <div class="container sm:max-w-screen-lg">
      <h1 class="text-2xl font-medium mb-4">Ask a question</h1>
      <form class="form" @submit.prevent="submit">
        <div class="form__group">
          <label for="title" class="form__group__label"> Title </label>
          <input type="text" name="title" id="title" class="form__group__control" v-model="form.title" required />
          <p
            v-if="errors.title"
            class="form__group__description form__group__description--error"
            v-text="errors.title"
          />
        </div>
        <div class="form__group">
          <label class="form__group__label"> Body </label>
          <markdown-editor v-model="form.body" />
          <p v-if="errors.body" class="form__group__description form__group__description--error" v-text="errors.body" />
        </div>
        <div class="form__group">
          <label class="form__group__label"> Tags </label>
          <tag-input :tags-list="tagsList" v-model="form.tags" />
          <p v-if="errors.tags" class="form__group__description form__group__description--error" v-text="errors.tags" />
        </div>
        <div class="form__footer text-right">
          <button type="submit" class="button button--primary mb-4" :disabled="form.processing">Submit question</button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import MarkdownEditor from '@/Components/Generic/MarkdownEditor'
import TagInput from '@/Components/TagInput'

export default {
  name: 'Create.vue',
  components: { TagInput, MarkdownEditor },
  props: {
    tagsList: {
      type: Array,
      default: [],
    },
    errors: {
      type: Object,
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        title: null,
        body: null,
        tags: [],
      }),
    }
  },
  methods: {
    submit() {
      this.form.post(this.route('questions.store'))
    },
  },
}
</script>
