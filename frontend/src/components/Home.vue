<template>
  <MHeader title="Блог"></MHeader>
  <MMain></MMain>
</template>
  
<script>
import MHeader from './Header.vue'
import MMain from './Main/Main.vue'

export default {
  name: 'MHome',
  components: {
    MHeader,
    MMain

  }
}
</script>