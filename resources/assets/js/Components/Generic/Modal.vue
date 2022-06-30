<template>
  <div
    :class="{ hidden: !visible }"
    class="modal"
    tabindex="-1"
    :aria-labelledby="`modal-${title}`"
    aria-hidden="true"
    role="dialog"
    aria-modal="true"
  >
    <div class="modal__container">
      <div class="modal__background" aria-hidden="true"></div>
      <span class="modal__centered" aria-hidden="true">&#8203;</span>
      <div class="modal__card">
        <div class="modal__card__header">
          <div class="modal__card__header__left">
            <slot name="header-left"></slot>
          </div>
          <div class="modal__card__header__center">
            <slot name="header-center"></slot>
          </div>
          <div class="modal__card__header__right">
            <slot name="header-right">
              <button class="button button--white button--icon" type="button" @click.prevent="close">
                <font-awesome-icon icon="fa-solid fa-xmark fa-lg fa-fw" />
              </button>
            </slot>
          </div>
        </div>
        <div class="modal__card__body">
          <slot name="body"></slot>
        </div>
        <div v-if="hasFooter" class="modal__card__footer">
          <slot name="footer" :actions="{ close }"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Modal',
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
