<template>
  <modal title="user-profile-edit" v-model="visibleProxy">
    <template #header-left>
      <h1 class="font-medium pl-2 text-slate-800">Edit your profile</h1>
    </template>
    <template #body>
      <form class="form">
        <div class="user-profile user-profile--editing">
          <header class="user-profile__header">
            <img
              v-show="headerPreview"
              :src="headerPreview"
              class="user-profile__header__background user-profile__header__background--editing"
              alt="Upload a new header background for your profile"
            />
            <div class="user-profile__edit">
              <button type="button" class="user-profile__edit__button" @click="$refs.headerInput.click()">
                <font-awesome-icon icon="fa-solid fa-plus fa-fw" />
              </button>
              <input
                ref="headerInput"
                class="user-profile__edit__input"
                type="file"
                name="avatar-upload"
                accept="image/jpeg,image/png,image/webp"
                @change="onInputChange($event, 'header')"
              />
            </div>
          </header>
          <section class="section">
            <div class="container">
              <div class="user-profile__avatar user-profile__avatar--editing">
                <img :src="avatarPreview" alt="Upload a new image for your user profile" />
                <div class="user-profile__edit">
                  <button type="button" class="user-profile__edit__button" @click="$refs.avatarInput.click()">
                    <font-awesome-icon icon="fa-solid fa-plus fa-fw" />
                  </button>
                  <input
                    ref="avatarInput"
                    class="user-profile__edit__input"
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
          </section>
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
import Alert from '@/Components/Alert'

export default {
  name: 'EditProfileModal',
  model: {
    prop: 'visible',
    event: 'toggle',
  },
  components: { Alert, Modal },
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
