<template>
  <textarea ref="markdownEditor"></textarea>
</template>

<script>
import EasyMDE from 'easymde'

export default {
  name: 'MarkdownEditor',
  props: {
    placeholder: {
      type: String,
      default: 'Write your **text** here',
    },
    value: {
      type: String,
    },
  },
  data() {
    return {
      markdownEditor: null,
      options: {
        autofocus: false,
        placeholder: this.placeholder,
        indentWithTabs: false,
        spellChecker: false,
        previewClass: [
          'editor-preview',
          'prose',
          'prose-slate',
          'hover:prose-a:text-primary-600',
          'dark:hover:prose-a:text-primary-500',
          'dark:prose-invert',
          'max-w-none',
        ],
      },
    }
  },
  mounted() {
    this.markdownEditor = new EasyMDE({
      element: this.$refs.markdownEditor,
      ...this.options,
    })

    this.markdownEditor.codemirror.on('change', () => this.$emit('input', this.markdownEditor.value()))

    if (this.value) {
      this.markdownEditor.value(this.value)
    }
  },
  watch: {
    value(newValue) {
      if (this.value === newValue) {
        return
      }

      this.markdownEditor.value(newValue)
    },
  },
}
</script>
