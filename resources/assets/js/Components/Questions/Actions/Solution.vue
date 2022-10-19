<template>
  <form @submit.prevent="markSolution">
    <button
      :class="{ 'text-emerald-500 hover:text-emerald-600': active }"
      class="mt-2 text-3xl text-slate-300 hover:text-slate-400"
      type="submit"
      :disabled="!canMarkSolution"
    >
      <font-awesome-icon icon="fa-solid fa-check" />
    </button>
  </form>
</template>

<script>
export default {
  name: 'SolutionComponent',
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
