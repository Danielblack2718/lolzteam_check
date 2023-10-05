<template>
    <div class="reviews__item">
        <div class="review__top">
            <span class="review__author">
                {{ review.author }}
            </span>
            <span class="review__time">
                {{  review.time }}
            </span>
        </div>
        <span class="review__desc">
           {{  review.desc }}
        </span>

    </div>
</template>
    
<script>

export default {
    name: 'MReviewItem',
    props: {
        review: Object
    }
}
</script>
