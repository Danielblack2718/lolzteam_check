<template>
  <div class="post" v-if="post" style="white-space: pre-line;">
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
        {{ post.time }}
      </span>
    </div>
  </div>
  <div v-else>
    <p>Пост с таким ID не найден {{ this.id }}</p>
  </div>
  <MReviews :admin="admin" :reviews="post.reviews"></MReviews>
</template>

<script>
import MReviews from './Review/Review.vue';
export default {
  name: 'MMain',
  props: {
    id: Number
  },
  components: {
    MReviews
  },
  data() {
    return {
      currentPage: 1,
      pageSize: 10,
      posts: [
        {
          id: 4, title: 'Lorem2fsdfsdsdfdfsdsdfsdfsdfsdf sdfsdfsdfdsffsfsdfsdfsdfsdfsdfsdfsdfsdfsfsfsdfsfdsfsfsdf', short_desc: 'Description 1', desc: 'fsdfsdfsdfsdfsdf sdfsdffsdfsdfsdfsdfsdffsdfsdfsdfsdfsdffsdfsdfsdfsdfsdff sdfsdfsdfsdfsdffsdfsdfsdfsdfsdffsdfsdfsdfsdfsdffsdfsdfsdf', time: 'Time 1', author: 'Daniel',
          reviews: [
            { id: 1, author: 'Daniel', desc: 'sdf', time: ' ' }
          ]
        },
        {
          id: 5, reviews: [
            { id: 1, author: 'Daniel', desc: 'sdf', time: ' ' },
            { id: 2, author: 'Daniel', desc: 'sdf', time: ' ' },
            { id: 3, author: 'Daniel', desc: 'sdf', time: ' ' },
            { id: 4, author: 'Daniel', desc: 'sdf', time: ' ' },
            { id: 5, author: 'Daniel', desc: 'sdf', time: ' ' },
            { id: 6, author: 'Daniel', desc: 'sdf', time: ' ' },
          ],
          title: 'Posription 1Description 1Description 1Description 1Dription 1Description 1Description 1Description 1Dription 1Description 1Description 1Description 1Dription 1Description 1Description 1Description 1Dription 1Description 1Description 1Description 1Dt 1', short_desc: 'Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1Description 1', desc: 'sadfsdfsdsdfsd', time: 'Time 1', author: 'Daniel'
        },
        { id: 6, title: 'Post 6', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
        { id: 7, title: 'Post 13', short_desc: 'Description 1', desc: 'sadfsdfsdsdfsd', time: 'Time 1', author: 'Daniel' },
        { id: 8, title: 'Post 7', short_desc: 'Description 1', desc: 'sadfsdfsdsdfsd', time: 'Time 1', author: 'Daniel' },
        { id: 9, title: 'Post 1', short_desc: 'Description 1', desc: 'sadfsdfsdsdfsd', time: 'Time 1', author: 'Daniel' },
        { id: 10, title: 'Post 8', short_desc: 'Description 1', desc: 'sadfsdfsdsdfsd', time: 'Time 1', author: 'Daniel' },
        { id: 12, title: 'Post 14', short_desc: 'Description 1', desc: 'sadfsdfsdsdfsd', time: 'Time 1', author: 'Daniel' },
        { id: 14, title: 'Post 9', short_desc: 'Description 1', desc: 'sadfsdfsdsdfsd', time: 'Time 1', author: 'Daniel' },
      ],
    }
  },
  computed: {
    post() {
      return this.posts.find(p => p.id === Number(this.id));
    }
  }

}
</script>
