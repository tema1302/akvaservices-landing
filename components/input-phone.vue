<template lang="pug">
  input.rounded-full.py-3.px-8(type="text", placeholder="+7", @input="trimPhone($event.target.value)", value="+7", :maxlength="lengthPhone", v-phone)
</template>

<script>
import Vue from 'vue'
Vue.directive('phone', {
  bind(el) {
    el.oninput = function (e) {
      if (!e.isTrusted) {
        return
      }
      const x = this.value
        .replace(/\D/g, '')
        .match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,4})/)

      if (!x[2] && x[1] !== '') {
        this.value = x[1] === '7' ? '+7' : '+7' + x[1]
      } else {
        this.value = !x[3]
          ? '+' + x[1] + x[2]
          : '+' + x[1] + ' (' + x[2] + ') ' + x[3] + (x[4] ? '-' + x[4] : '')
      }
    }
  },
})
export default {
  name: 'InputPhone',
  data() {
    return {
      lengthPhone: 17,
    }
  },
  methods: {
    trimPhone(phone) {
      this.$emit('inputedPhone', '+' + phone.replace(/[^0-9]/g, ''))
    },
  },
}
</script>
