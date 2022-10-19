<template>
  <div class="w-full">
    <div class="border-b border-slate-300 dark:border-slate-300">
      <ul class="-mb-px flex flex-wrap space-x-2 text-center text-sm font-medium text-slate-500 dark:text-slate-300">
        <!-- FIXME:  | aria-current="page" -->
        <li v-for="tab in tabs" :key="tab.key">
          <a
            href="#"
            :class="{
              'border-blue-600 text-blue-600 dark:border-primary-400 dark:text-primary-400': tab.key === activeTab,
            }"
            :aria-current="tab.key === activeTab"
            class="inline-flex border-b-2 border-transparent p-4 hover:border-primary-600 hover:text-primary-600"
            @click.prevent="activeTab = tab.key"
            v-text="tab.name"
          />
        </li>
      </ul>
    </div>
    <slot :name="activeTab"></slot>
  </div>
</template>

<script>
export default {
  name: 'Tabs',
  props: {
    tabs: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      activeTab: null,
    }
  },
  created() {
    this.activeTab = this.tabs[0].key
  },
  watch: {
    activeTab(newVal) {
      this.$emit('changed', newVal)
    },
  },
}
</script>
