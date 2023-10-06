<template>
    <MHeader title="Статья"></MHeader>
    <main>
        <MReviews></MReviews>
    </main>
</template>
  
<script>
import MReviews from '../Post/Review/Review.vue';

export default {
    name: 'App',
    components: {
        MReviews
    },
}
</script>