<template>
  <div class="buttons">
    <tippy :message="shareMessage" :hideOnClick="false" :open.sync="showShareTippy" trigger="manual" placement="top">
      <Link
        :class="classes"
        as="button"
        @mouseenter="showShareTippy = true"
        @mouseleave="showShareTippy = false"
        @click.stop.prevent="share"
      >
        <i class="fas fa-link"></i>
        Share
      </Link>
    </tippy>
    <Link v-if="canEdit" :class="classes" :href="editRoute" as="button">
      <i class="fas fa-edit"></i>
      Edit
    </Link>
    <Link v-if="canDelete" :class="classes" :href="deleteRoute" method="delete" as="button">
      <i class="fas fa-trash-alt"></i>
      Delete
    </Link>
    <Link v-if="canRestore" :href="restoreRoute" :class="classes" method="post" as="button">
      <i class="fas fa-trash-restore"></i>
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
      classes: [
        'transition-all',
        'font-semibold',
        'hover:text-primary-600',
        'focus:text-primary-800',
        'active:text-primary-800',
      ],
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
