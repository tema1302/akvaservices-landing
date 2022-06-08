<template lang="pug">
  .landing
    section.landing--main.min-h-screen.relative.flex.items-center.justify-center.flex-col.bg-center.bg-no-repeat.bg-cover
      .relative.z-10.font-bold(class="text-2xl md:text-4xl lg:text-6xl mb-6 md:mb-10") АкваСервис
      .relative.z-10.text-center(class="text-base md:text-xl ") Сервисная служба по ремонту и обслуживанию автомоечных комплексов и шиномонтажей
      .absolute.down-click.z-10.bottom-10.animate-bounce.cursor-pointer
        DownClick
    section.landing--services
      .font-bold.text-center(class="text-2xl md:text-4xl lg:text-6xl mb-10 md:mb-20") Услуги
      .landing--services-wrapper(class="flex overflow-auto md:grid md:overflow-hidden md:grid-cols-2 lg:grid-cols-3 md:gap-5")
        .landing--services-item.flex.flex-col(v-for="(service, idx) in services" :key="idx", class="mr-3 md:mr-0 p-4 md:p-6")
          .title.font-semibold(class="text-base md:text-lg mb-2 md:mb-4") {{ service.title }}
          .desc.text-white(class="text-xs md:text-sm") {{ service.desc }}
    section.landing--form.bg-center.bg-no-repeat.bg-cover.relative
      form.relative.z-10.mx-auto.max-w-lg(@submit.prevent="sendData")
        .field.flex.flex-col.mt-3(class="md:mt-5")
          label.mb-2.text-white Email
          input.rounded-full.py-3.px-8(type="email", v-model="email", placeholder="mycompany@co.com", :class="error ? 'error' : ''")
        .field.flex.flex-col.mt-3(class="md:mt-5")
          label.mb-2.text-white Имя
          input.rounded-full.py-3.px-8(type="text", v-model="name", placeholder="Иван Иванов", :class="error ? 'error' : ''")
        .field.flex.flex-col.mt-3(class="md:mt-5")
          label.mb-2.text-white Телефон
          input.rounded-full.py-3.px-8(type="number", v-model="number", placeholder="+7", :class="error ? 'error' : ''")
        button.py-3.px-6.text-base.w-full.font-semibold.my-12(type="submit") Заказать обратный звонок
        .text-white.text-xs.text-center Нажимая на кнопку, вы соглашаетесь с условиями о персональных данных
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
    <div style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/213/moscow/search/%D0%90%D0%BA%D0%B2%D0%B0%D1%81%D0%B8%D1%82%D0%B8/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Аквасити в Москве</a><a href="https://yandex.ru/maps/213/moscow/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:14px;">Москва</a><iframe src="https://yandex.ru/map-widget/v1/-/CCUJJRWX9B" width="100%" height="250" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>
</template>

<script>
export default {
  name: 'IndexPage',
  data() {
    return {
      email: '',
      name: '',
      number: '',
      error: false,
      services: [
        {
          title: 'Монтаж моечного оборудования',
          desc: 'Мы производим монтаж оборудования автомоек под ключ (установка, подключение, прокладка трасс).',
        },
        {
          title: 'ТО и ремонт аппаратов высокого давления',
          desc: 'Регламентное обслуживание АВД, регулировка давления, замена клапанов, ремонт байпасов, электродвигателей, выключателей.',
        },
        {
          title: 'Изготовление и замена рукавов высокого давления',
          desc: 'Изготавливаем РВД по вашим размерам, выезжаем на замену.',
        },
        {
          title: 'Ремонт секционных ворот и автоматики',
          desc: 'Смазка ворот, замена роликов и кронштейнов, регулировка натяжения и замена пружин, замена секций ворот, замена окон ворот, установка привода, программироваение ключей, настройка концевых положений, ремонт автоматики.',
        },
        {
          title: 'ТО и ремонт компрессоров',
          desc: 'Плановое техническое обслуживание винтовых и поршневых компрессоров. Ремонт компрессоров, осмотр пневмомагистралей, устранение утечек воздуха.',
        },
        {
          title: 'Обслуживание дозатронов и пеногенераторов',
          desc: 'Плановое обслуживание, замена или ремонт дозатронов.',
        },
        {
          title: 'Ремонт пылеводососов',
          desc: 'Диагностика пылеводососов, замена турбин, ремонт проводки, ремонт баков.',
        },
        {
          title: 'Профилактические осмотры',
          desc: 'Выезд на ваш объект, осмотр и контроль работы оборудования, составление плана работ по обслуживанию.',
        },
        {
          title: 'Обслуживание шиномонтажного и балансировочного оборудования',
          desc: 'Диагностика и ремонт оборудования, устранение утечек воздуха, калибровка балансировочного оборудования.',
        },
        {
          title: 'Обслуживание пневмоинструмента',
          desc: 'Устранение утечек воздуха, регулировка лубрикаторов, ремонт гайковертов и другого пневмоинструмента.',
        },
        {
          title: 'Проверка динамометрических ключей',
          desc: 'Ремонт динамометрических ключей, проверка на стенде.',
        },
        {
          title: 'Ремонт электрики и электроинструмента',
          desc: 'Поиск неисправностей, диагностика, ремонт электропроводки, замена выключателей и розеток, замена плафонов и прожекторов, электромонтажные работы. Диагностика и ремонт электроинструмента (полировочные машинки, озонаторы, термофоггеры и т.д.).',
        },
        {
          title:
            'Проектирование и строительство автомоечных комплексов и шиномонтажей под ключ',
          desc: 'Подготовим проект под ваше ТЗ, занимаемся строительством под ключ, подберем всё необходимое оборудование.',
        },
      ],
    }
  },
  // computed: {
  //   error() {
  //     return (
  //
  //     )
  //   },
  // },
  methods: {
    sendData() {
      if (
        this.email.length < 5 ||
        this.name.length < 5 ||
        this.number.length < 5
      )
        this.error = true

      
    },
  },
}
</script>
<style lang="scss">
.landing {
}
</style>
