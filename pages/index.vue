<template lang="pug">
  .landing
    section.landing--main.min-h-screen.relative.flex.items-center.justify-center.flex-col.bg-center.bg-no-repeat.bg-cover
      .relative.z-10.font-bold(class="text-2xl md:text-4xl lg:text-6xl mb-6 md:mb-10", v-html="$t('title')")
      .relative.z-10.text-center(class="text-base md:text-xl ", v-html="$t('subtopic')")
      .absolute.down-click.z-10.bottom-10.animate-bounce.cursor-pointer
        <svg @click="smoothScrollToServices" class="t-cover__arrow-svg" style="fill:#dcc89a;" x="0px" y="0px" width="38.417px" height="18.592px" viewBox="0 0 38.417 18.592"><g><path d="M19.208,18.592c-0.241,0-0.483-0.087-0.673-0.261L0.327,1.74c-0.408-0.372-0.438-1.004-0.066-1.413c0.372-0.409,1.004-0.439,1.413-0.066L19.208,16.24L36.743,0.261c0.411-0.372,1.042-0.342,1.413,0.066c0.372,0.408,0.343,1.041-0.065,1.413L19.881,18.332C19.691,18.505,19.449,18.592,19.208,18.592z"></path></g></svg>
    section.landing--services
      .font-bold.text-center(class="text-2xl md:text-4xl lg:text-6xl mb-10 md:mb-20") Услуги
      .landing--services-wrapper(class="flex overflow-auto md:grid md:overflow-hidden md:grid-cols-2 lg:grid-cols-3 md:gap-5")
        .landing--services-item.flex.flex-col(v-for="idx in 13" :key="idx", class="mr-3 md:mr-0 p-4 md:p-6")
          .title.font-semibold(class="text-base md:text-lg mb-2 md:mb-4", v-html="$t(`sec2-title-${idx}`)")
          .desc.text-white(class="text-xs md:text-sm", v-html="$t(`sec2-description-${idx}`)")
    section.landing--form.bg-center.bg-no-repeat.bg-cover.relative
      form.relative.z-10.mx-auto.max-w-lg(@submit.prevent="sendData")
        .field.flex.flex-col.mt-3(class="md:mt-5")
          label.mb-2.text-white Email
          input.rounded-full.py-3.px-8(type="email", v-model="formData.email", placeholder="mycompany@co.com", :class="error ? 'error' : ''")
        .field.flex.flex-col.mt-3(class="md:mt-5")
          label.mb-2.text-white Имя
          input.rounded-full.py-3.px-8(type="text", v-model="formData.name", placeholder="Иван Иванов", :class="error ? 'error' : ''")
        .field.flex.flex-col.mt-3(class="md:mt-5")
          label.mb-2.text-white Телефон
          input.rounded-full.py-3.px-8(type="number", v-model="formData.number", placeholder="+7", :class="error ? 'error' : ''")
        button.py-3.px-6.text-base.w-full.font-semibold.my-12(type="submit") Заказать обратный звонок
        .text-white.text-xs.text-center Нажимая на кнопку, вы соглашаетесь с условиями о персональных данных
    <div style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/213/moscow/search/%D0%90%D0%BA%D0%B2%D0%B0%D1%81%D0%B8%D1%82%D0%B8/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Аквасити в Москве</a><a href="https://yandex.ru/maps/213/moscow/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:14px;">Москва</a><iframe src="https://yandex.ru/map-widget/v1/-/CCUJJRWX9B" width="100%" height="250" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>
    section.landing--footer
      .contacts
        .contacts-title.font-bold(class="text-2xl md:text-4xl lg:text-6xl mb-6 md:mb-10") Контакты
        .flex.items-end.justify-between
          div
            .text-xl Телефон: +7
            .text-xl E-mail: m.svintsov@akvacity.ru
          .text-base Укажите адрес вашей компании
          .soc-network.flex
            a(href="", target="_blank")
              img.mr-3(src="@/static/images/twitter.svg")
            a(href="", target="_blank")
              img.mr-3(src="@/static/images/vk.svg")
            a(href="", target="_blank")
              img(src="@/static/images/telegram.svg")
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
      },
      error: false,
    }
  },
  async fetch() {
    let localeLink = ''
    if (process.env.NODE_ENV === 'production') {
      localeLink =
        '/service-landing/js_langs/' +
        this.$i18n.locale +
        '.json?v=' +
        Math.random()
    } else {
      localeLink = '/js_langs/' + this.$i18n.locale + '.json?v=' + Math.random()
    }
    const localeRes = await fetch(localeLink)
    const locale = await localeRes.json()
    this.$i18n.setLocaleMessage(this.$i18n.locale, locale)

    this.loaded = true
  },
  methods: {
    async sendData() {
      if (
        this.formData.email.length < 5 ||
        this.formData.name.length < 5 ||
        this.formData.number.length < 5
      )
        this.error = true
      else {
        const form = new FormData()
        form.append('data', JSON.stringify(this.formData))
        try {
          const response = await this.$axios.post('/sendEmail/', form)
          console.log(response)
          if (response.data === 'ok') alert('Всё ок, имейл отправлен')
        } catch (e) {
          console.log(e.response)
        }
      }
    },
    smoothScrollToServices() {
      console.log('123')
      const servicesBlock = document.querySelector('.landing--services')
      console.log(servicesBlock)
      servicesBlock.scrollIntoView({ block: 'start', behavior: 'smooth' })
    },
  },
}
</script>
<style lang="scss">
.landing {
}
</style>
