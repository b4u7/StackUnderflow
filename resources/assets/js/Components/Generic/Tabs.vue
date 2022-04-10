<template>
  <div>
    <div class="tabs">
      <ul class="tabs__list">
        <!-- FIXME:  | aria-current="page" -->
        <li v-for="tab in tabs" :key="tab.key">
          <a
            href="#"
            :class="{ 'tabs__item--active': tab.key === activeTab }"
            :aria-current="tab.key === activeTab"
            class="tabs__item"
            v-text="tab.name"
            @click.prevent="activeTab = tab.key"
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
}
</script>
