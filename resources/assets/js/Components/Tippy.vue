<script>
import tippy from 'tippy.js'
import 'tippy.js/dist/tippy.css'

export default {
  name: 'Tippy',
  props: {
    message: {
      type: String,
      required: true
    },
    interactive: {
      type: Boolean,
      default: false
    },
    placement: {
      type: String,
      default: 'bottom'
    },
    trigger: {
      type: String
    },
    open: {
      type: Boolean
    },
    hideOnClick: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      instance: null
    }
  },
  render(h) {
    if (this.$slots.default.length > 1) {
      console.error('Attempted to use Tippy component with more than one child! Only the first child will be rendered')
    }

    const vNode = this.$slots.default[0]

    // console.log(vNode)

    vNode.data.ref = 'target'

    if (vNode.componentOptions) {
      return h(vNode.componentOptions.Ctor, vNode.data, vNode.children)
    }

    return h(vNode.tag, vNode.data, vNode.children)
  },
  mounted() {
    const target = this.$refs.target

    let element
    if (target instanceof HTMLElement) {
      element = target
    } else if (target.$el) {
      element = target.$el
    }

    this.instance = tippy(element, {
      content: this.message,
      placement: this.placement,
      trigger: this.trigger,
      interactive: this.interactive,
      hideOnClick: this.hideOnClick,
      onHide: () => this.$emit('update:open', false),
      onShow: () => this.$emit('update:open', true)
    })
  },
  watch: {
    message(newVal) {
      this.instance.setContent(newVal)
    },
    trigger(newVal) {
      this.instance.setProps({ trigger: newVal })
    },
    open(newVal) {
      newVal ? this.instance.show() : this.instance.hide()
    }
  },
  beforeDestroy() {
    this.instance?.destroy()
  }
}
</script>
