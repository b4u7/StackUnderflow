<template>
  <div :class="{ 'tag-input--selected': searching && filteredTagsList.length > 0 }" class="tag-input">
    <div class="tag-input__box">
      <tags :tags="selectedTags" removable @tag-remove="removeTag" />
      <input
        @click="openDropdown"
        @keyup="event => addTag({ name: query, new: true }, event)"
        v-model="query"
        class="tag-input__search"
        type="text"
        name="tag-input"
      />
      <div v-if="searching && filteredTagsList.length > 0" class="tag-input__dropdown">
        <div class="tag-input__dropdown__container">
          <div v-for="(tag, index) in filteredTagsList">
            <button
              :key="index"
              class="tag-input__dropdown__button"
              type="button"
              @click="event => addTag(tag.item, event)"
            >
              {{ tag.item.name }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Fuse from 'fuse.js'
import Tags from '@/Components/Tags'
import Tag from '@/Components/Tag'

import { includes, isEmpty, trim } from 'lodash'

export default {
  name: 'TagInput',
  components: { Tags, Tag },
  props: {
    tagsList: {
      type: Array,
      default: [],
    },
  },
  data() {
    return {
      searching: false,
      selectedTags: [],
      query: '',
      fuse: new Fuse([], { keys: ['name'], threshold: 0.2 }),
    }
  },
  watch: {
    tagsList: {
      immediate: true,
      handler(value) {
        this.fuse.setCollection(value)
      },
    },
  },
  computed: {
    filteredTagsList() {
      return this.fuse.search(this.query).filter(result => !includes(this.selectedTags, result.item))
    },
  },
  methods: {
    openDropdown() {
      this.searching = true
    },
    closeDropdown() {
      this.searching = false
    },
    addTag(tag, event) {
      if (this.selectedTags.length >= 5) {
        return
      }

      const allowedKeys = [',', ' ', 'enter', 'delete', 'backspace']
      if (!event.key || (event.key && !allowedKeys.includes(event.key.toLowerCase()))) {
        return
      }

      tag.name = trim(tag.name, ' ,\t')

      // FIXME: Lazy
      if (event.key.toLowerCase() === 'backspace') {
        this.removeTag(tag)
        return
      }

      if (isEmpty(tag.name)) {
        return
      }

      if (tag.new) {
        tag = this.tagsList.find(t => t.name === tag.name) ?? tag
      }

      this.selectedTags.push(tag)
      this.query = ''
    },
    removeTag(tag = null) {
      if (this.selectedTags.length <= 0) {
        return
      }

      const index = tag
        ? this.selectedTags.findIndex(t => t.id === tag.id)
        : this.selectedTags[this.selectedTags.length - 1]
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
