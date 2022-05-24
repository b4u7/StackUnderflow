<template>
  <form @submit.prevent="markSolution">
    <button
      :class="{ [classes.active]: active }"
      class="actions__item actions__solution"
      type="submit"
      :disabled="!canMarkSolution"
    >
      <font-awesome-icon icon="fa-solid fa-check" />
    </button>
  </form>
</template>

<script>
export default {
  name: 'Solution',
  props: {
    active: {
      type: Boolean,
      required: true,
    },
    canMarkSolution: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      classes: {
        active: 'actions__item--active',
      },
    }
  },
  methods: {
    markSolution() {
      this.$emit('mark-solution')
    },
  },
}
</script>
