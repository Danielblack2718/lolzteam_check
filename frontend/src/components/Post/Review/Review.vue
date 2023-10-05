<template>
    <div class="review">
        <span class="review__h2">
            Комментарии
        </span>
        <span @click="showModal = true;" class="review__h2 pointer">Добавить комментарий</span>
        <Modal v-if="showModal" @close="showModal = false" title="Добавить комментарий">
            <label for="author">Автор комментария</label>
            <input type="text" id="author" placeholder="Ваше имя">
            <label for="description">Описание комментария</label>
            <textarea name="" id="description" placeholder="Отзыв"></textarea>
            <button class="btn btn-primary" @click="addReview()">Добавить</button>
        </Modal>
    </div>
    <div class="reviews__content">
        <MReviewItem v-for="(review, index) in displayedPosts" :key="index" :review="review"></MReviewItem>
    </div>
</template>
    
<script>
import MReviewItem from './ReviewItem.vue';
import Modal from '../../Modal/Modal.vue';
export default {
    name: 'MReview',
    components: {
        MReviewItem,
        Modal
    },
    computed: {
        totalPages() {
            return Math.ceil(this.review.length / this.pageSize);
        },
        displayedPosts() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            return this.review.slice(start, end);
        }
    },
    methods: {
        previousPage() {
            this.currentPage -= 1;
        },
        nextPage() {
            this.currentPage += 1;
        },
        goToPage(page) {
            this.currentPage = page;
        },
        addReview() {
            this.review.push({
                id: this.review.length + 1,
                desc: document.getElementById('description').value,
                author: document.getElementById('author').value,
                time: new Date().toLocaleString(),
            });
        }
    },

    data() {
        return {
            currentPage: 1,
            pageSize: 20,
            review: [
                { id: 1, desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 2, desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 3, desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 5, desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 6, desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 7, desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 8, desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 9, desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
            ],
            showModal: false
        };
    }
}
</script>