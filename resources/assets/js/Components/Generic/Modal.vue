<template>
  <div
    :class="{ hidden: !visible }"
    :aria-labelledby="`modal-${title}`"
    class="fixed inset-0 z-20 overflow-y-auto"
    aria-modal="true"
    aria-hidden="true"
    role="dialog"
    tabindex="-1"
  >
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
      <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
      <div
        class="relative inline-block transform overflow-hidden rounded-md bg-white text-left align-bottom shadow-xl ring-1 ring-transparent transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle"
      >
        <div class="flex min-h-[3rem] flex-row items-center py-1 px-2">
          <div>
            <slot name="header-left"></slot>
          </div>
          <div class="inline-flex flex-grow justify-center">
            <slot name="header-center"></slot>
          </div>
          <div>
            <slot name="header-right">
              <button class="button button--white button--icon" type="button" @click.prevent="close">
                <font-awesome-icon icon="fa-solid fa-xmark fa-lg fa-fw" />
              </button>
            </slot>
          </div>
        </div>
        <div class="flex max-h-[80vh] flex-grow flex-col overflow-y-auto">
          <slot name="body"></slot>
        </div>
        <div v-if="hasFooter" class="block space-y-8 py-3 px-4 sm:flex-row sm:space-y-0">
          <slot name="footer" :actions="{ close }"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ModalComponent',
  model: {
    prop: 'visible',
    event: 'toggle',
  },
  props: {
    title: {
      type: String,
      required: true,
    },
    hasFooter: {
      type: Boolean,
      default: true,
    },
    visible: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    visibleProxy: {
      get() {
        return this.visible
      },
      set(newVal) {
        this.$emit('toggle', newVal)
      },
    },
  },
  methods: {
    open() {
      this.visibleProxy = true
    },
    close() {
      this.visibleProxy = false
    },
  },
}
</script>
