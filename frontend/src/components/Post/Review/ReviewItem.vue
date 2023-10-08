<template>
    <div class="reviews__item">
        <div class="review__top">
            <span class="review__author">
                {{ review.author }}
            </span>
            <span class="review__time">
                {{ review.created_at }}
            </span>
        </div>
        <span class="review__desc">
            {{ review.desc }}
        </span>
        <div class="admin_buttons" v-if="adminKey || userId == review.user_id">
            <div class="button red" @click="showModal = true;">Удалить</div>
        </div>
    </div>

    <Modal v-if="showModal" @close="showModal = false" title="Удалить пост">
        <label for="">Вы действительно хотите удалить пост?</label>
        <div class="modal__bottom">
            <button class="button red" @click="deleteReview()">Удалить</button>
        </div>
    </Modal>
</template>
    
<script>
import Modal from '../../Modal/Modal.vue';
import sweetAlertMixin from '@/mixins/sweet-alert-mixin'

export default {
    name: 'MReviewItem',
    mixins: [sweetAlertMixin],
    props: {
        review: Object,
        admin: Boolean
    },
    components: {
        Modal
    },
    mounted() {
        this.userId = this.getOrCreateUserId();
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
        deleteReview() {
            this.showModal = false;
            try {
                fetch(`http://localhost/public/api/review/${this.review.id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8',
                        'Authorization': `Bearer ${this.adminKey}`
                    },
                    body: JSON.stringify({

                    })
                })
                    .then(response => response.json())
                    .then(result => {
                        console.log(result);
                        this.showSuccessMessage("Успех", "Вы успешно удалили комментарий")
                        this.$emit('delete', this.review.id); // отправка события delete
                    })
                    .catch(error => console.log(error));
            } catch (e) {
                this.showErrorMessage("Ошибка", "При добавлении комментария произошла ошибка");
                console.log(e);
            }
        }
    },
    data() {
        return {
            showModal: false,
            adminKey: this.$cookies.get("adminKey"),
            userId: null
        };
    }
}
</script>
