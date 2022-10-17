<template>
  <section class="section mt-8">
    <div class="container sm:max-w-screen-lg">
      <h1 class="mb-4 text-2xl font-medium">Ask a question</h1>
      <form class="form" @submit.prevent="submit">
        <div :class="{ 'form__group--error': errors.title }" class="form__grou">
          <label for="title" class="form__group__label"> Title </label>
          <input
            type="text"
            name="title"
            id="title"
            class="form__group__control"
            v-model="form.title"
            autofocus
            required
          />
          <p v-if="!errors.title" class="form__group__description">
            Be specific and imagine you’re asking a question to another person
          </p>
          <p v-else class="form__group__description">
            <font-awesome-icon icon="fa-solid fa-circle-exclamation" />
            {{ errors.title }}
          </p>
        </div>
        <div :class="{ 'form__group--error': errors.body }" class="form__group">
          <label class="form__group__label"> Body </label>
          <markdown-editor v-model="form.body" />
          <p v-if="!errors.body" class="form__group__description">
            Include all the information someone would need to answer your question
          </p>
          <p v-else class="form__group__description">
            <font-awesome-icon icon="fa-solid fa-circle-exclamation" />
            {{ errors.body }}
          </p>
        </div>
        <div :class="{ 'form__group--error': errors.tags }" class="form__group">
          <label class="form__group__label"> Tags </label>
          <tag-input :tags-list="tagsList" v-model="form.tags" />
          <p v-if="!errors.tags" class="form__group__description">
            Add up to 5 tags to describe what your question is about
          </p>
          <p v-else class="form__group__description">
            <font-awesome-icon icon="fa-solid fa-circle-exclamation" />
            {{ errors.tags }}
          </p>
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
