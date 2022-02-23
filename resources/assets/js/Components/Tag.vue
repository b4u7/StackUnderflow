<script>
export default {
  name: 'Tag',
  props: {
    tag: {
      type: Object,
      required: true
    },
    inline: {
      type: Boolean,
      default: false
    },
    removable: {
      type: Boolean,
      default: false
    }
  },
  render(h) {
    return h(
      this.inline ? 'span' : 'li',
      {
        class: ['tag', this.tag.colour && `tag--${this.tag.colour}`]
      },
      [
        h('span', {
          class: 'tag__title',
          domProps: {
            innerHTML: this.tag.name
          }
        }),
        this.removable &&
        h(
          'span',
          {
            class: 'tag__close',
            on: {
              click: this.remove
            }
          },
          [h('i', { class: ['fas', 'fa-times'] })]
        )
      ]
    )
  },
  methods: {
    remove() {
      this.$emit('tag-remove', this.tag)
    }
  }
}
</script>
