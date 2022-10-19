<script>
export default {
  name: 'TagComponent',
  props: {
    tag: {
      type: Object,
      required: true,
    },
    inline: {
      type: Boolean,
      default: false,
    },
    removable: {
      type: Boolean,
      default: false,
    },
  },
  render(h) {
    return h(
      this.inline ? 'span' : 'li',
      {
        class: [
          'inline-flex cursor-pointer whitespace-nowrap rounded-full text-sm leading-relaxed',
          this.tag.colour
            ? `tag-${this.tag.colour}`
            : 'bg-sky-50 text-sky-600 hover:bg-sky-100 focus:bg-sky-200 active:bg-sky-200',
        ],
      },
      [
        h('span', {
          class: 'mx-4',
          domProps: {
            innerHTML: this.tag.name,
          },
        }),
        this.removable &&
          h(
            'span',
            {
              class: 'w-6 text-center bg-blend-darken ml-1',
              on: {
                click: this.remove,
              },
            },
            [h('i', { class: ['fas', 'fa-times'] })]
          ),
      ]
    )
  },
  methods: {
    remove() {
      this.$emit('tag-remove', this.tag)
    },
  },
}
</script>
