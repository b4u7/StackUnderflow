<template>
  <form @submit.prevent="markSolution">
    <button
      :class="{ [classes.active]: active }"
      :disabled="!canMarkSolution"
      type="submit"
      class="actions__item actions__solution"
    >
      <i class="fas fa-check"></i>
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
