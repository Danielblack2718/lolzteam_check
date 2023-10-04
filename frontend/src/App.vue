<template>

  <MHeader></MHeader>
  <MMain></MMain>

</template>

<script>
  import MHeader from './components/Header.vue'
  import MMain from './components/Main.vue'
  export default {
    name: 'App',
    components: {
      MHeader,
      MMain
    }
  }
</script>