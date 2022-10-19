<template>
  <div
    class="relative mt-1 flex w-full flex-row items-center rounded-md border-0 border-transparent bg-white px-2 shadow-sm ring-1 ring-slate-300 sm:text-sm"
  >
    <TagsList :tags="selectedTags" removable @tag-remove="removeTag" />
    <input
      class="w-full appearance-none rounded-md border-none text-sm focus:border-none focus:outline-none focus:ring-0 active:border-none active:outline-none active:ring-0"
      type="text"
      name="tag-input"
      @click="openDropdown"
      @keydown="handleInput"
      v-model="query"
    />
    <div
      v-if="selected"
      class="absolute top-16 left-0 z-10 block max-h-48 min-w-[200px] origin-top-left overflow-y-scroll rounded-md bg-white text-sm shadow-lg"
    >
      <div class="flex flex-col p-2">
        <DropdownButton
          v-for="(tag, index) in filteredTagsList"
          :key="index"
          type="button"
          @click.prevent="addTag(tag.item)"
        >
          {{ tag.item.name }}
        </DropdownButton>
      </div>
    </div>
  </div>
</template>

<script>
import Fuse from 'fuse.js'
import DropdownButton from '@/Components/Navbar/DropdownButton'
import TagsList from '@/Components/TagsList'

import { includes, isEmpty, trim } from 'lodash'

export default {
  name: 'TagInputComponent',
  model: {
    prop: 'value',
    event: 'input',
  },
  components: { DropdownButton, TagsList },
  props: {
    tagsList: {
      type: Array,
      default: () => [],
    },
    value: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      searching: false,
      query: '',
      fuse: new Fuse([], { keys: ['name'], threshold: 0.2 }),
    }
  },
  watch: {
    tagsList: {
      immediate: true,
      handler(newVal) {
        this.fuse.setCollection(newVal)
      },
    },
  },
  computed: {
    filteredTagsList() {
      return this.fuse.search(this.query).filter(result => !includes(this.selectedTags, result.item))
    },
    selectedTags: {
      set(value) {
        this.$emit('input', value)
      },
      get() {
        return this.value
      },
    },
    selected() {
      return this.searching && this.filteredTagsList.length > 0
    },
  },
  methods: {
    openDropdown() {
      this.searching = true
    },
    closeDropdown() {
      this.searching = false
    },
    handleInput(event) {
      const keyCode = event.key?.toLowerCase()

      if (this.selectedTags.length >= 5 && keyCode !== 'backspace') {
        event.preventDefault()
        return
      }

      const allowedKeys = [',', ' ', 'enter', 'backspace']
      if (!allowedKeys.includes(keyCode)) {
        return
      }

      if (keyCode === 'backspace' && !isEmpty(this.query)) {
        return
      }

      event.preventDefault()

      let tag = { name: this.query, new: true }
      tag.name = trim(tag.name, ' ,\t')

      if (keyCode === 'backspace') {
        if (isEmpty(tag.name)) {
          this.removeTag()
        }

        return
      }

      if (isEmpty(tag.name)) {
        return
      }

      if (tag.new) {
        tag = this.tagsList.find(t => t.name === tag.name) ?? tag
      }

      this.addTag(tag)
    },
    addTag(tag) {
      if (this.selectedTags.find(t => t.name === tag.name)) {
        return
      }

      this.selectedTags.push(tag)
      this.query = ''
    },
    removeTag(tag = null) {
      if (this.selectedTags.length <= 0) {
        return
      }

      const index = tag ? this.selectedTags.findIndex(t => t.id === tag.id) : this.selectedTags.length - 1

      this.selectedTags.splice(index, 1)
    },
  },
}
</script>

<style lang="scss" scoped>
.tag-selector {
  @apply relative;
}
</style>
