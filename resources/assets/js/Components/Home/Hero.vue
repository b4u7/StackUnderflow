<template>
  <div class="flex flex-col overflow-hidden bg-slate-900 text-white">
    <div>
      <slot name="header" />
    </div>
    <div class="flex flex-shrink-0 flex-grow items-center">
      <div class="container">
        <slot name="body" />
      </div>
    </div>
    <div>
      <slot name="footer" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'HeroComponent',
  props: {
    leading: {
      type: String,
    },
    subtitle: {
      type: String,
    },
  },
}
</script>
