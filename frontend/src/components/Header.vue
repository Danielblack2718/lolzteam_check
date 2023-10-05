<template>
  <header>
    <a href="/"><img src="../assets/img/logo.png" width="25" alt=""></a>
    <h1>{{ title }}</h1>
  </header>
</template>

<script>
  export default {
    name: 'MHeader',
    props: {
      title: String
    }
  }
</script>