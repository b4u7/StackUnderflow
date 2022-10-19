<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  name: 'DropdownButton',
  components: { Link },
  props: {
    type: {
      type: String,
      required: true,
    },
    as: {
      type: String,
    },
    href: {
      type: String,
    },
  },
  render(h) {
    const allowedTypes = ['Link', 'a', 'button']
    if (!allowedTypes.includes(this.type)) {
      console.error('Component type is not supported')
      return
    }

    return h(
      this.type,
      {
        class: 'flex w-full rounded-md py-1.5 px-2 text-slate-900 hover:bg-slate-200',
        props: {
          as: this.as,
          href: this.href,
        },
        on: this.$listeners,
      },
      this.$slots.default
    )
  },
}
</script>
