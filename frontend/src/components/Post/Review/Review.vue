<template>
    <div class="review">
        <span class="review__h2">
            Комментарии {{ totalReviews }}
        </span>
        <span @click="showModal = true;" class="review__h2 pointer">Добавить комментарий</span>
        <Modal v-if="showModal" @close="showModal = false" title="Добавить комментарий">
            <label for="author">Автор комментария</label>
            <input type="text" id="author" placeholder="Ваше имя">
            <label for="description">Описание комментария</label>
            <textarea name="" id="description" placeholder="Отзыв"></textarea>
            <div class="modal__bottom">
                    <span class="error">Не все поля заполнены</span>
                    <button class="button green" @click="addReview()">Добавить</button>
                </div>
        </Modal>
    </div>
    <div class="reviews__content">
        <MReviewItem v-for="(review, index) in LocalReview" :key="index" :review="review" :admin="admin"></MReviewItem>  
    </div>
</template>
    
<script>
import MReviewItem from './ReviewItem.vue';
import Modal from '../../Modal/Modal.vue';
export default {
    name: 'MReview',
    data() {
        return {
            currentPage: 1,
            pageSize: 20,
            showModal: false,
            LocalReview: this.reviews
        };
    },
    components: {
        MReviewItem,
        Modal
    },
    props: {
        admin: Boolean,
        reviews: Array
    },
    computed: {
        totalReviews() {
            if(this.LocalReview){
                return this.LocalReview.length;
            }
            else return 0;
        },
        totalPages() {
            return Math.ceil(this.LocalReview.length / this.pageSize);
        },
        displayedPosts() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            return this.LocalReview.slice(start, end);
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
            var author = document.getElementById('author');
            var description = document.getElementById('description');
            
            author.classList.remove('error_input');    
            description.classList.remove('error_input');
            if (author.value == '') {
                document.querySelector('.error').style.display = 'block';
                author.classList.add('error_input');
                return;
            }
            if (description.value == '') {
                document.querySelector('.error').style.display = 'block';
                description.classList.add('error_input');
                return;
            }

            document.querySelector('.error').style.display = 'none';
            this.showModal = false;
            if(this.LocalReview == null) this.LocalReview = new Array();
            this.LocalReview.push({
                id: this.LocalReview.length + 1,
                author: author.value,
                desc: description.value,
                time: new Date().toLocaleString()

            }
            );
            
            author.value = '';
            description.value = '';
        },
    },


}
</script>