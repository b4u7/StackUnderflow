<script>
export default {
  name: 'RenderedMarkdown',
  props: {
    html: {
      type: String,
      required: true,
    },
  },
  render(h) {
    return h('article', {
      class: [
        'prose',
        'prose-slate',
        'hover:prose-a:text-primary-600',
        'dark:hover:prose-a:text-primary-500',
        'dark:prose-invert',
      ],
      domProps: {
        innerHTML: this.html,
      },
    })
  },
}
</script>
