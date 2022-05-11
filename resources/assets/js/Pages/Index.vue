<template>
  <hero class="hero--medium">
    <template #body>
      <h1 class="hero__leading">Learn, Share, Build</h1>
      <div class="hero__cta">
        <p>
          <Link class="button button--warning button--xl" as="button" :href="route('register')">
            Join the community
            <font-awesome-icon icon="fa-solid fa-arrow-right" />
          </Link>
        </p>
        <p>
          or
          <Link class="underline font-medium text-yellow-400" :href="route('questions.index')">search for content</Link>
        </p>
      </div>
    </template>
  </hero>
</template>

<script>
import Hero from '@/Components/Home/Hero'
import { Link } from '@inertiajs/inertia-vue'

export default {
  name: 'Index',
  components: { Hero, Link },
}
</script>
