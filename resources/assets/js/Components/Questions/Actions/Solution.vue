<template>
  <form @submit.prevent="markSolution">
    <button
      :class="{ 'actions__item--active': active }"
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
  methods: {
    markSolution() {
      this.$emit('mark-solution')
    },
  },
}
</script>
