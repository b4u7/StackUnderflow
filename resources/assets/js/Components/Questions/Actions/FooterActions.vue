<template>
  <div class="w-full space-x-6 text-sm sm:w-auto">
    <tippy :message="shareMessage" :hideOnClick="false" :open.sync="showShareTippy" trigger="manual" placement="top">
      <Link
        class="font-semibold transition-all hover:text-primary-600 focus:text-primary-800 active:text-primary-800"
        as="button"
        @mouseenter="showShareTippy = true"
        @mouseleave="showShareTippy = false"
        @click.stop.prevent="share"
      >
        <font-awesome-icon icon="fa-solid fa-link" />
        Share
      </Link>
    </tippy>
    <Link
      v-if="canEdit"
      :href="editRoute"
      class="font-semibold transition-all hover:text-primary-600 focus:text-primary-800 active:text-primary-800"
      as="button"
    >
      <font-awesome-icon icon="fa-solid fa-pen-to-square" />
      Edit
    </Link>
    <Link
      v-if="canDelete"
      :href="deleteRoute"
      class="font-semibold transition-all hover:text-red-600 focus:text-red-800 active:text-red-800"
      method="delete"
      as="button"
    >
      <font-awesome-icon icon="fa-solid fa-trash-can" />
      Delete
    </Link>
    <Link
      v-if="canRestore"
      :href="restoreRoute"
      class="font-semibold transition-all hover:text-green-600 focus:text-green-800 active:text-green-800"
      method="post"
      as="button"
    >
      <font-awesome-icon icon="fa-solid fa-trash-can-arrow-up" />
      Restore
    </Link>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import Tippy from '@/Components/Tippy'
import copy from 'copy-to-clipboard'

const SHARE_MESSAGE = 'Copy link to this question'

export default {
  name: 'FooterActions',
  components: { Tippy, Link },
  props: {
    canEdit: {
      type: Boolean,
      required: true,
    },
    canDelete: {
      type: Boolean,
      required: true,
    },
    canRestore: {
      type: Boolean,
      required: true,
    },
    data: {
      type: Object,
    },
    isTrashed: {
      type: Boolean,
      required: true,
    },
    shareUrl: {
      type: String,
      required: true,
    },
    editRoute: {
      type: String,
      required: true,
    },
    deleteRoute: {
      type: String,
      required: true,
    },
    restoreRoute: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      shareMessage: SHARE_MESSAGE,
      showShareTippy: false,
    }
  },
  methods: {
    async share() {
      copy(this.shareUrl)

      this.shareMessage = 'Copied to clipboard!'

      setTimeout(() => {
        this.showShareTippy = false

        setTimeout(() => (this.shareMessage = SHARE_MESSAGE), 1000)
      }, 1000)
    },
  },
}
</script>
