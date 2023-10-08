<template>
    <div class="reviews__item">
        <div class="review__top">
            <span class="review__author">
                {{ review.author }}
            </span>
            <span class="review__time">
                {{ review.time }}
            </span>
        </div>
        <span class="review__desc">
            {{ review.desc }}
        </span>
        <div class="admin_buttons" v-if="adminKey">
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

export default {
    name: 'MReviewItem',
    props: {
        review: Object,
        admin: Boolean
    },
    components: {
        Modal
    },
    methods: {
        deleteReview() {
            this.showModal = false;
            try {
                fetch(`http://localhost/public/api/review/${this.review.id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify({
                        adminKey: this.adminKey
                    })
                })
                    .then(response => response.json())
                    .then(result => {
                        console.log(result);
                        this.$emit('delete', this.review.id); // отправка события delete
                    })
                    .catch(error => console.log(error));
            } catch (e) {
                console.log(e);
            }
        }
    },
    data() {
        return {
            showModal: false,
            adminKey: this.$cookies.get("adminKey")
        };
    }
}
</script>
