<template>
  <nav class="secondary-navbar">
    <div class="container">
      <div class="secondary-navbar__start">
        <a class="secondary-navbar__item" :href="route('users.index')">Users</a>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'SecondaryNavbar',
}
</script>
