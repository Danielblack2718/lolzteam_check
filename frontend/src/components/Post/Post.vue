<template>
  <div v-if="loading" class="loader">
  </div>
  <div v-else>
    <div v-if="post" class="post" style="white-space: pre-line;">
      <span class="post__title">
        {{ post.title }}
      </span>
      <span class="post__desc">
        {{ post.desc }}
      </span>
      <div class="post__bottom">
        <span class="bottom__author">
          {{ post.author }}
        </span>
        <span class="bottom__time">
          {{ post.created_at }}
        </span>
      </div>
    </div>
    <div v-else class="post nothing">
      <span class="post__title">
        Пост с таким id не найден
      </span>
    </div>
  </div>

  <MReviews v-if="post" :admin="admin" :key="post.comments.length" :reviews="post.comments"></MReviews>
</template>

<script>
import MReviews from './Review/Review.vue';
export default {
  name: 'MMain',
  props: {
    id: Number,
    admin: Boolean
  },
  components: {
    MReviews
  },
  data() {
    return {
      post: null,
      loading: true, // начальное состояние загрузки
      intervalId: null
    }
  },
  mounted() {
    this.fetchPost();
    this.intervalId = setInterval(() => {
      this.fetchPost();
      console.log('423423')
    }, 15000); // 15 секунд = 15000 мс
  },
  beforeUnmount() { // замените beforeDestroy на beforeUnmount
    if (this.intervalId) {
      clearInterval(this.intervalId);
    }
  },
  methods: {

    async fetchPost() {
      try {
        const response = await fetch(`http://localhost/public/api/post/${this.id}`);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();

        if (this.post) {
          // Обновить только комментарии, если пост уже был загружен ранее
          this.post.comments = data.comments;
        } else {
          // Полная загрузка поста, если это первый запрос
          this.post = data;
        }
      } catch (error) {
        
        console.error('There has been a problem with your fetch operation:', error);
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>
