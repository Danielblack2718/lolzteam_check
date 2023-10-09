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
        <MReviewItem v-for="(review) in LocalReview" :key="review.id" :review="review" :admin="admin"
            @delete="removeReview"></MReviewItem>
    </div>
</template>
    
<script>
import MReviewItem from './ReviewItem.vue';
import Modal from '../../Modal/Modal.vue';
import sweetAlertMixin from '../../../mixins/sweet-alert-mixin'
export default {
    name: 'MReview',
    mixins: [sweetAlertMixin],
    data() {
        return {
            currentPage: 1,
            pageSize: 20,
            showModal: false,
            LocalReview: this.reviews,
            userId: null
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
            if (this.LocalReview) {
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
        getOrCreateUserId() {
            // Check if the user ID exists in cookies
            let userId = this.getCookie('userId');

            // If not, generate a new ID and set it as a cookie
            if (!userId) {
                userId = this.generateUserId();
                this.setCookie('userId', userId, 365);
            }

            return userId;
        },

        generateUserId() {
            // Generate a random string as the user ID
            return Math.random().toString(36).substr(2, 9);
        },

        setCookie(name, value, days) {
            const d = new Date();
            d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = name + "=" + value + ";" + expires + ";path=/";
        },

        getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        },
        removeReview(id) {
            this.LocalReview = this.LocalReview.filter(LocalReview => LocalReview.id !== id);
        },
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


            if (this.LocalReview == null) this.LocalReview = new Array();
            try {
                fetch('/public/api/review', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        author: author.value,
                        desc: description.value,
                        post_id: this.$route.params.id,
                        user_id: this.userId
                    })
                })
                    .then(response => {
                        console.log(response)
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        this.showSuccessMessage("Успех", "Вы успешно добавили комментарий");

                        this.LocalReview.push({
                            id: this.LocalReview.length + 1,
                            author: author.value,
                            desc: description.value,
                            created_at: data.created_at,
                            user_id: this.userId
                        }
                        );
                    })
                    .catch(error => {
                        this.showErrorMessage("Ошибка", "При добавлении комментария произошла ошибка");
                        console.error('There has been a problem with your fetch operation:', error);
                    });
            } catch (error) {
                this.showErrorMessage("Ошибка", "При добавлении комментария произошла ошибка");
                console.error('There was an error fetching the posts!', error);
            }
        },
    },
    mounted() {
        this.userId = this.getOrCreateUserId();
    },


}
</script>