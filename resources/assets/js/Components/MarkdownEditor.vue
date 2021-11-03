<template>
  <textarea ref="markdownEditor"></textarea>
</template>

<script>
import EasyMDE from 'easymde'

export default {
  name: 'MarkdownEditor',
  props: {
    initialValue: {
      type: String,
      default: 'Write your **question** here',
    },
    value: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      markdownEditor: null,
      options: {
        autofocus: false,
        initialValue: this.initialValue,
        indentWithTabs: false,
      },
    }
  },
  mounted() {
    this.markdownEditor = new EasyMDE({
      element: this.$refs.markdownEditor,
      ...this.options,
    })

    this.markdownEditor.codemirror.on('change', () => this.$emit('input', this.markdownEditor.value()))
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
