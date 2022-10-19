<template>
  <span
    class="absolute top-0 right-0 inline-flex translate-x-4 -translate-y-4 transform items-center justify-center rounded-full bg-red-600 px-2 py-1 text-xs font-bold leading-none text-red-100"
  >
    <slot />
  </span>
</template>

<script>
export default {
  name: 'BadgeComponent',
}
</script>
