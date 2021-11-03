<template>
  <section class="section">
    <div class="container">
      <h1 class="text-2xl font-medium mb-4">Ask a question</h1>
      <form class="form">
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
          <markdown-editor v-model="form.body" />
        </div>
        <!-- TODO: Need to create a tag selector component -->
        <div class="form__group">
          <!-- Tags -->
        </div>
        <div class="form__footer text-right">
          <button type="submit" class="button button--primary mb-4" :disabled="form.processing">Submit question</button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import MarkdownEditor from '@/Components/MarkdownEditor'

export default {
  name: 'Create.vue',
  components: { MarkdownEditor },
  props: {
    errors: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        title: '',
        body: '',
        tags: [],
      }),
    }
  },
  methods: {
    submit() {
      this.form.post(this.route('login'))
    },
  },
}
</script>
