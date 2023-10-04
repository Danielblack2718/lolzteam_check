<template>
  <div class="post">
        <span class="post__title">{{ title }}</span>
        <div class="post__bottom">
            <span class="bottom__short-desc">{{ short_desc }}</span>
            <span class="bottom__time">{{ time }}</span>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'MMain',
    props: {
      title: String,
      short_desc: String,
      time: String
    }
  }
</script>