<template>
  <div :class="{ 'search--dark': dark }" class="search">
    <form @submit.prevent="submit">
      <input
        class="search__input"
        type="text"
        :placeholder="placeholder"
        :spellcheck="spellcheck"
        :autocomplete="autocomplete"
        v-model="query"
      />
    </form>
    <div class="search__dropdown">
      <div class="search__dropdown__container">
        <a v-for="result in results" href="" class="search__dropdown__item"> </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Search',
  props: {
    autocomplete: {
      type: Boolean,
    },
    placeholder: {
      type: String,
      required: true,
    },
    spellcheck: {
      type: Boolean,
    },
    dark: {
      type: Boolean,
    },
  },
  data() {
    return {
      query: '',
      results: [],
    }
  },
  methods: {
    submit() {},
  },
}
</script>
