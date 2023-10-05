<template>
  <div class="post__item" :key="index" @click="goToPost(post.id)">
    <span class="post__title">{{ post.title }}</span>
    <span class="post__short-desc">{{ post.short_desc }}</span>
    <div class="post__bottom">
      <span class="bottom__author">{{ post.author }}</span>
      <span class="bottom__time">{{ post.time }}</span>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'MMain',
    methods: {
      goToPost(postId) {
        this.$router.push({ path: `/post/${postId}` });
      }
    },
    props: {
      post: Object
    }
  }
</script>