<template>
  <div :class="{ 'tag-input--selected': searching && filteredTagsList.length > 0 }" class="tag-input">
    <div class="tag-input__box">
      <tags :tags="selectedTags" removable @tag-remove="removeTag" />
      <input
        @click="openDropdown"
        @keyup="event => addTag({ name: query, new: true }, event)"
        class="tag-input__search"
        type="text"
        name="tag-input"
        v-model="query"
      />
      <div v-if="searching && filteredTagsList.length > 0" class="tag-input__dropdown">
        <div class="tag-input__dropdown__container">
          <button
            v-for="(tag, index) in filteredTagsList"
            :key="index"
            type="button"
            class="tag-input__dropdown__button"
            @click="event => addTag(tag.item, event)"
            v-text="tag.item.name"
          />
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
  model: {
    prop: 'value',
    event: 'input'
  },
  components: { Tags, Tag },
  props: {
    tagsList: {
      type: Array,
      default: () => []
    },
    value: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      searching: false,
      query: '',
      fuse: new Fuse([], { keys: ['name'], threshold: 0.2 })
    }
  },
  watch: {
    tagsList: {
      immediate: true,
      handler(value) {
        this.fuse.setCollection(value)
      }
    }
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
      }
    }
  },
  // TODO: Probably have a method called handleInput instead of doing everything in addTag
  methods: {
    openDropdown() {
      this.searching = true
    },
    closeDropdown() {
      this.searching = false
    },
    // handleInput(tag, event) {
    //   const allowedKeys = [',', ' ', 'enter', 'delete', 'backspace']
    //
    //   if (event.key && !allowedKeys.includes(event.key?.toLowerCase())) {
    //     return
    //   }
    //
    //   tag.name = trim(tag.name, ' ,\t')
    // },
    addTag(tag, event) {
      if (this.selectedTags.length >= 5) {
        return
      }

      const allowedKeys = [',', ' ', 'enter', 'delete', 'backspace']

      // !event.key || (event.key && !allowedKeys.includes(event.key.toLowerCase()))
      if (event.key && !allowedKeys.includes(event.key?.toLowerCase())) {
        return
      }

      tag.name = trim(tag.name, ' ,\t')

      if (event.key?.toLowerCase() === 'backspace') {
        if (isEmpty(this.query)) {
          this.removeTag(tag)
        }

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
    }
  }
}
</script>

<style lang="scss" scoped>
.tag-selector {
  @apply relative;
}
</style>
