<template lang="pug">
  .landing
    div(class="overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full", v-if="modal", @click="closeModal")
      <div class="custom-modal max-w-xl mx-auto mt-32 relative rounded-lg shadow dark:bg-gray-700">
        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal">
          <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
        <div class="p-6 text-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="text-[#059669] mx-auto h-11 rounded-full bg-[#D1FAE5] w-11 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 13l4 4L19 7"></path>
          </svg>
          <h2 class="mb-5 text-base font-normal">Спасибо, что обратились в компанию Аквасити Сервис. Наш менеджер свяжется с Вами в ближайшее время</h2>
        </div>
      </div>
    section.landing--main.min-h-screen.relative.flex.items-center.justify-center.flex-col.bg-center.bg-no-repeat.bg-cover
      img.relative.z-10.mb-6(class="w-16 md:w-24 lg:w-36", src="@/static/images/logo.png")
      .relative.z-10.font-bold(class="text-2xl md:text-4xl lg:text-7xl mb-6 md:mb-10", v-html="$t('title')")
      .relative.z-10.text-center(class="text-base md:text-xl ", v-html="$t('subtopic')")
      .absolute.down-click.z-10.bottom-10.animate-bounce.cursor-pointer
        <svg @click="smoothScrollToServices" class="t-cover__arrow-svg" style="fill:#dcc89a;" x="0px" y="0px" width="38.417px" height="18.592px" viewBox="0 0 38.417 18.592"><g><path d="M19.208,18.592c-0.241,0-0.483-0.087-0.673-0.261L0.327,1.74c-0.408-0.372-0.438-1.004-0.066-1.413c0.372-0.409,1.004-0.439,1.413-0.066L19.208,16.24L36.743,0.261c0.411-0.372,1.042-0.342,1.413,0.066c0.372,0.408,0.343,1.041-0.065,1.413L19.881,18.332C19.691,18.505,19.449,18.592,19.208,18.592z"></path></g></svg>
    section.landing--services
      .font-bold.text-center(class="text-2xl md:text-4xl lg:text-6xl mb-10 md:mb-20", v-html="$t('sec2-h1')")
      .landing--services-wrapper(class="flex overflow-auto md:grid md:overflow-hidden md:grid-cols-2 lg:grid-cols-3 md:gap-5")
        .landing--services-item.flex.flex-col(v-for="idx in 13" :key="idx", class="mr-3 md:mr-0 p-4 md:p-6")
          .title.font-semibold(class="text-base md:text-lg mb-2 md:mb-4", v-html="$t(`sec2-title-${idx}`)")
          .desc.text-white(class="text-xs md:text-sm", v-html="$t(`sec2-description-${idx}`)")
    section.landing--form.bg-center.bg-no-repeat.bg-cover.relative
      form#form.relative.z-10.mx-auto.max-w-lg(@submit.prevent="sendData")
        .field.flex.flex-col.mt-3(class="md:mt-5")
          label.mb-2.text-white(v-html="$t('form-email')")
          input.rounded-full.py-3.px-8(type="email", v-model="formData.email", placeholder="mycompany@co.com", :class="error ? 'error' : ''")
        .field.flex.flex-col.mt-3(class="md:mt-5")
          label.mb-2.text-white(v-html="$t('form-name')")
          input.rounded-full.py-3.px-8(type="text", v-model="formData.name", placeholder="Иван Иванов", :class="error ? 'error' : ''")
        .field.flex.flex-col.mt-3(class="md:mt-5")
          label.mb-2.text-white(v-html="$t('form-phone')")
          input-phone.rounded-full.py-3.px-8(@inputedPhone="addTrimmedPhone" :class="error ? 'error' : ''")
        .field.flex.flex-col.mt-3(class="md:mt-5")
          label.mb-2.text-white(v-html="$t('form-content')")
          input.rounded-full.py-3.px-8(type="text", v-model="formData.content", :placeholder="$t('form-content-placeholder')", :class="error ? 'error' : ''")
        .field.flex.flex-col.mt-3(class="md:mt-5")
        button.py-3.px-6.text-base.w-full.font-semibold.my-12(v-if="!formIsSending", type="submit")
          span(v-html="$t('form-btn')")
        <svg v-else class="spinner" viewBox="0 0 50 50">
          <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
        </svg>
        .text-white.text-xs.text-center(v-html="$t('form-description')")
    <div style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/213/moscow/search/%D0%90%D0%BA%D0%B2%D0%B0%D1%81%D0%B8%D1%82%D0%B8/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Аквасити в Москве</a><a href="https://yandex.ru/maps/213/moscow/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:14px;">Москва</a><iframe src="https://yandex.ru/map-widget/v1/-/CCUJJRWX9B" width="100%" height="250" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>
    section.landing--footer
      .contacts
        .contacts-title.font-bold(class="text-2xl md:text-4xl lg:text-6xl mb-6 md:mb-10", v-html="$t('sec3-h1')")
        .flex.items-end.justify-between
          div
            .text-xl {{ $t('sec3-phone-title') }}&nbsp;
              a(:href="`tel:${$t('sec3-phone')}`", v-html="$t('sec3-phone')")
            .text-xl {{ $t('sec3-email-title') }}&nbsp;
              a(:href="`mailto:${$t('sec3-email')}`", v-html="$t('sec3-email')")
          .soc-network.flex
            //- a(href="", target="_blank")
            //-   img.mr-3(src="@/static/images/twitter.svg")
            a(href="https://vk.com/vkakvacity", target="_blank")
              img.mr-3(src="@/static/images/vk.svg")
            //- a(href="", target="_blank")
            //-   img(src="@/static/images/telegram.svg")
</template>

<script>
export default {
  name: 'IndexPage',
  data() {
    return {
      formData: {
        email: '',
        name: '',
        number: '',
        content: '',
      },
      error: false,
      formIsSending: false,
      modal: false,
    }
  },
  async fetch() {
    let localeLink = ''
    if (process.env.NODE_ENV === 'production') {
      localeLink =
        '/service/js_langs/' + this.$i18n.locale + '.json?v=' + Math.random()
    } else {
      localeLink = '/js_langs/' + this.$i18n.locale + '.json?v=' + Math.random()
    }
    const localeRes = await fetch(localeLink)
    const locale = await localeRes.json()
    this.$i18n.setLocaleMessage(this.$i18n.locale, locale)

    this.loaded = true
  },
  methods: {
    addTrimmedPhone(number) {
      this.formData.number = number
    },
    closeModal() {
      this.modal = false
      document.body.classList.remove('modal-open')
    },
    async sendData() {
      if (
        this.formData.email.length < 5 ||
        this.formData.name.length < 5 ||
        this.formData.content.length < 5 ||
        this.formData.number.length < 5
      )
        this.error = true
      else {
        this.formIsSending = true

        const form = new FormData()
        form.append('data', JSON.stringify(this.formData))
        try {
          const response = await this.$axios.post('/dev/sendEmail/', form)
          console.log(response)
          if (response.data === 'ok') {
            this.formIsSending = false
            this.modal = true
            document.body.classList.add('modal-open')
            this.formData.email = ''
            this.formData.name = ''
            this.formData.number = ''
            this.formData.content = ''
            document.getElementById('form').reset()
          }
        } catch (e) {
          console.log(e.response)
        }
      }
    },
    smoothScrollToServices() {
      const servicesBlock = document.querySelector('.landing--services')
      servicesBlock.scrollIntoView({ block: 'start', behavior: 'smooth' })
    },
  },
}
</script>
<style lang="scss">
body.modal-open {
  overflow: hidden;
}

.spinner {
  animation: rotate 2s linear infinite;
  z-index: 2;
  position: absolute;
  top: 50%;
  left: 50%;
  margin: -25px 0 0 -25px;
  width: 50px;
  height: 50px;

  & .path {
    stroke: #93bfec;
    stroke-linecap: round;
    animation: dash 1.5s ease-in-out infinite;
  }
}

.custom-modal {
  background: #374151;
}

@keyframes rotate {
  100% {
    transform: rotate(360deg);
  }
}

@keyframes dash {
  0% {
    stroke-dasharray: 1, 150;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 90, 150;
    stroke-dashoffset: -35;
  }
  100% {
    stroke-dasharray: 90, 150;
    stroke-dashoffset: -124;
  }
}
</style>
