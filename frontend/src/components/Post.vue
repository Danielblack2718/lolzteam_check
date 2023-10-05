<template>
    <MHeader title="Статья"></MHeader>
    <MPost></MPost>
    <MReviews></MReviews>
</template>
  
<script>
import MPost from './Post/Post.vue';
import MHeader from './Header.vue';
import MReviews from './Post/Review/Review.vue';
export default {
    name: 'App',
    components: {
        MPost,
        MHeader,
        MReviews,
     
    },
}
</script>