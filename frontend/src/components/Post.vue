<template>
    <MHeader title="Статья"></MHeader>
    <main>
        <MPost></MPost>
        <MReviews></MReviews>

        
    </main>
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