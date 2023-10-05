<template>
    <main>

        <div class="posts">
            <span @click="showModal = true;" class="create_post pointer">Добавить пост</span>
            <Modal v-if="showModal" @close="showModal = false" title="Добавить пост">
                <label for="author">Автор поста</label>
                <input type="text" id="author" placeholder="Ваше имя">
                <label for="description">Описание поста</label>
                <textarea name="" id="description" placeholder="Описание поста"></textarea>
            </Modal>
            <Post v-for="(post, index) in displayedPosts" :key="index" :post="post" />
        </div>

        <nav>
            <ul class="pagination">
                <li v-bind:class="{ 'non-active': currentPage === 1 }">
                    <a @click="currentPage > 1 ? previousPage() : null">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            stroke="#ffffff">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M6 12H18M6 12L11 7M6 12L11 17" stroke="#ffffff" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </a>
                </li>
                <li :class="{ active: currentPage === 1 }">
                    <a @click="goToPage(1)" >1</a>
                </li>
                <li v-if="currentPage > 2">
                    <span>...</span>
                </li>
                <li
                    v-if="currentPage > 2 && currentPage < totalPages - 1 || currentPage == 2 || currentPage == totalPages - 1" :class="{ active: true }">
                    <a @click="goToPage(currentPage)" >{{ currentPage }}</a>
                </li>
                <li v-if="totalPages > 1 && currentPage != totalPages && currentPage != totalPages - 1">
                    <span>...</span>
                </li>
                <li :class="{ active: currentPage === totalPages }">
                    <a @click="goToPage(totalPages)" >{{ totalPages
                    }}</a>
                </li>
                <li v-bind:class="{ 'non-active': currentPage >= totalPages }">
                    <a @click="currentPage < totalPages ? nextPage() : null"><svg width="20px" height="20px"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="#ffffff" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg></a>
                </li>
            </ul>
        </nav>
    </main>
</template>

<script>
import Post from './Post.vue';
import Modal from '../Modal/Modal.vue';
export default {
    name: 'MMain',
    components: {
        Post,
        Modal
    },
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
            posts: [
                { id: 4, title: '534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534534', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 5, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 6, title: 'Post 6', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 7, title: 'Post 13', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 8, title: 'Post 7', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 9, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 10, title: 'Post 8', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 12, title: 'Post 14', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 14, title: 'Post 9', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 156, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 15, title: 'Post 150', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 15, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 132, title: 'Post 2', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 156436, title: 'Post 161', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 3', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 4', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 12', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 5', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 6', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 13', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 7', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 8', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 14', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 9', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 150', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 2', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 161', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 3', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 4', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 12', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 5', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 6', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 13', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 7', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 8', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 14', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 9', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 150', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 2', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 161', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 3', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 4', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 12', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 5', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 6', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 13', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 7', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 8', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 14', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 9', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 150', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 2', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 161', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 3', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 4', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 12', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 5', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 6', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 13', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 7', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 8', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 14', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 9', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 150', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 2', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 161', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 3', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 1', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },

                { id: 4, title: 'Post 4', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
                { id: 4, title: 'Post 12', short_desc: 'Description 1', time: 'Time 1', author: 'Daniel' },
            ],
            showModal: false
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.posts.length / this.pageSize);
        },
        displayedPosts() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            return this.posts.slice(start, end);
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
        }
    }
};
</script>