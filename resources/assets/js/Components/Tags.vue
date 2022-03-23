<template>
  <ul class="tags">
    <tag
      v-for="(tag, index) in tags"
      :key="index"
      :tag="tag"
      :inline="inline"
      :removable="removable"
      @tag-remove="remove"
    />
  </ul>
</template>

<script>
import Tag from '@/Components/Tag'

export default {
  name: 'Tags',
  components: { Tag },
  props: {
    tags: {
      type: Array,
      required: true
    },
    inline: {
      type: Boolean,
      default: false
    },
    removable: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    remove(tag) {
      this.$emit('tag-remove', tag)
    }
  }
}
</script>
