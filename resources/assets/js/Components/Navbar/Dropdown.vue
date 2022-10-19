<template>
  <div ref="dropdown">
    <div @click="toggle">
      <slot name="button" />
    </div>
    <transition enter-active-class="transition" enter-class="opacity-0" leave-to-class="opacity-0">
      <div
        v-if="visible"
        :class="classes"
        class="absolute top-14 z-10 block overflow-x-hidden rounded-md bg-white text-sm shadow-lg"
      >
        <slot name="content" :actions="{ close }" />
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  name: 'DropdownComponent',
  props: {
    origin: {
      type: String,
      default: 'origin-top-left',
    },
    position: {
      type: String,
      default: 'top-14',
    },
    minWidth: {
      type: String,
      default: '200px',
    },
  },
  data() {
    return {
      visible: false,
      classes: [this.origin, this.position, `min-w-[${this.minWidth}]`],
    }
  },
  mounted() {
    if (!this.$refs.dropdown) {
      return
    }

    document.addEventListener('click', this.onDocumentClick)
  },
  beforeDestroy() {
    if (!this.$refs.dropdown) {
      return
    }

    document.removeEventListener('click', this.onDocumentClick)
  },
  methods: {
    onDocumentClick(e) {
      if (!this.$refs.dropdown) {
        return
      }

      if (!this.$refs.dropdown.contains(e.target)) {
        this.close()
      }
    },
    toggle() {
      this.visible = !this.visible
    },
    close() {
      this.visible = false
    },
  },
}
</script>
