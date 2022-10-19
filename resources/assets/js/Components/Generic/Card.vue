<template>
  <div class="flex flex-col rounded-md bg-white shadow ring-1 ring-transparent">
    <!-- <slot name="header" class="flex flex-row py-3 px-4" /> -->
    <slot name="header"></slot>
    <div class="px-4">
      <slot name="body" />
    </div>
    <slot name="footer" />
  </div>
</template>

<script>
export default {
  name: 'CardComponent',
}
</script>
