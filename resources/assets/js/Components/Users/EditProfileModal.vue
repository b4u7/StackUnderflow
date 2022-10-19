<template>
  <modal title="user-profile-edit" v-model="visibleProxy">
    <template #header-left>
      <h1 class="pl-2 font-medium text-slate-800">Edit your profile</h1>
    </template>
    <template #body>
      <form class="form">
        <div class="overflow-hidden">
          <div class="relative flex h-64 max-h-64 items-center justify-center overflow-hidden bg-slate-100">
            <img
              v-show="headerPreview"
              :src="headerPreview"
              class="h-full w-full object-cover object-center"
              alt="Upload a new header background for your profile"
            />
            <div class="absolute">
              <button
                type="button"
                class="relative z-10 rounded-full bg-slate-900 bg-opacity-50 p-2 leading-none text-white hover:bg-opacity-70"
                @click="$refs.headerInput.click()"
              >
                <font-awesome-icon class="h-4 w-4" icon="fa-solid fa-plus fa-fw" />
              </button>
              <input
                ref="headerInput"
                type="file"
                class="absolute top-0 bottom-0 left-0 right-0 mx-auto h-[1px] w-[1px] opacity-0"
                name="avatar-upload"
                accept="image/jpeg,image/png,image/webp"
                @change="onInputChange($event, 'header')"
              />
            </div>
          </div>
          <div class="container py-4">
            <div
              class="relative z-10 -mt-20 flex h-32 w-32 items-center justify-center overflow-hidden rounded-full border-4 border-white"
            >
              <img :src="avatarPreview" class="brightness-90" alt="Upload a new image for your user profile" />
              <div class="absolute">
                <button type="button" class="user-profile__edit__button" @click="$refs.avatarInput.click()">
                  <font-awesome-icon icon="fa-solid fa-plus fa-fw" />
                </button>
                <input
                  ref="avatarInput"
                  class="absolute top-0 bottom-0 left-0 right-0 mx-auto h-[1px] w-[1px] opacity-0"
                  type="file"
                  name="avatar-upload"
                  accept="image/jpeg,image/png,image/webp"
                  @change="onInputChange($event, 'avatar')"
                />
              </div>
            </div>
            <!-- TODO: Temporary -->
            <ul v-if="errors.header || errors.avatar" class="mt-4 mb-4 space-y-2 text-sm text-red-500">
              <li v-if="errors.header">
                <p v-text="errors.header" />
              </li>
              <li v-if="errors.avatar">
                <p v-text="errors.avatar" />
              </li>
            </ul>
            <!-- FIXME: Make form its own component -->
            <div :class="{ 'form__group--error': errors.name }" class="form__group mt-4">
              <div class="form__group">
                <label for="name" class="form__group__label"> Name </label>
                <input type="text" name="name" class="form__group__control" v-model="form.name" />
                <p v-if="errors.name" class="form__group__description">
                  <font-awesome-icon icon="fa-solid fa-circle-exclamation" />
                  {{ errors.name }}
                </p>
              </div>
            </div>
            <div :class="{ 'form__group--error': errors.biography }" class="form__group">
              <div class="form__group">
                <label for="biography" class="form__group__label"> Biography </label>
                <textarea
                  class="form__group__control"
                  autocapitalize="sentences"
                  autocomplete="on"
                  maxlength="160"
                  name="biography"
                  spellcheck="true"
                  dir="auto"
                  v-model="form.biography"
                />
                <p v-if="errors.biography" class="form__group__description">
                  <font-awesome-icon icon="fa-solid fa-circle-exclamation" />
                  {{ errors.name }}
                </p>
              </div>
            </div>
            <div :class="{ 'form__group--error': errors.company }" class="form__group">
              <div class="form__group">
                <label for="company" class="form__group__label"> Company </label>
                <input type="text" name="company" class="form__group__control" v-model="form.company" />
                <p v-if="errors.company" class="form__group__description">
                  <font-awesome-icon icon="fa-solid fa-circle-exclamation" />
                  {{ errors.company }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </form>
    </template>
    <template #footer="{ actions: { close } }">
      <div class="text-right">
        <button class="button button--primary button--responsive" type="button" @click.prevent="submit">
          Save changes
        </button>
        <button class="button button--secondary button--responsive" type="button" @click.prevent="close">Cancel</button>
      </div>
    </template>
  </modal>
</template>

<script>
import Modal from '@/Components/Generic/Modal'

export default {
  name: 'EditProfileModal',
  model: {
    prop: 'visible',
    event: 'toggle',
  },
  components: { Modal },
  props: {
    user: {
      type: Object,
      required: true,
    },
    errors: {
      type: Object,
    },
    visible: {
      type: Boolean,
      default: false,
    },
    status: {
      type: String,
    },
  },
  computed: {
    visibleProxy: {
      get() {
        return this.visible
      },
      set(newVal) {
        this.$emit('toggle', newVal)
      },
    },
  },
  data() {
    return {
      avatarPreview: this.user.avatar,
      headerPreview: this.user.header,
      form: this.$inertia.form({
        avatar: null,
        name: this.user.name,
        biography: this.user.biography,
        company: this.user.company,
        email: this.user.email,
      }),
    }
  },
  methods: {
    onInputChange(event, key) {
      let reader = new FileReader()
      reader.addEventListener('load', () => (this[`${key}Preview`] = reader.result))

      this.form[key] = event.target.files[0]
      reader.readAsDataURL(event.target.files[0])
    },
    submit() {
      this.form
        .transform(data => {
          const newData = {
            ...data,
            _method: 'PUT',
          }

          if (this.form.header) {
            newData.header = this.form.header
          }

          return newData
        })
        .post(this.route('user-profile-information.update'), {
          onSuccess: () => (this.visibleProxy = false),
        })
    },
  },
}
</script>
