<template>
    <main>

        <!--
        FILEPATH: d:\Lolzteam\frontend\src\components\Main\Main.vue
        DESCRIPTION: This component displays a list of posts and a button to add a new post. 
        When the "Добавить пост" button is clicked, a modal window appears with input fields for the author, title, short description, and description of the post. 
        The user can add a new post by filling out the input fields and clicking the "Добавить" button. If any of the input fields are empty, an error message is displayed. 
        The component also displays all the existing posts using the Post component.
        -->
        <div class="posts">
            <div v-if="loading" class="loader">
            </div>
            <div v-else>
                <span @click="showModal = true;" class="create_post pointer">Добавить пост</span>
                <Modal v-if="showModal" @close="showModal = false" title="Добавить пост">
                    <label for="author">Автор поста</label>
                    <input type="text" id="author" placeholder="Ваше имя">
                    <label for="title">Заголовок</label>
                    <input type="text" id="title" placeholder="Заголовок">
                    <label for="short_desc">Краткое описание поста</label>
                    <textarea name="" id="short_desc" placeholder="Краткое описание поста"></textarea>
                    <label for="description">Описание поста</label>
                    <textarea name="" id="description" placeholder="Описание поста"></textarea>

                    <div class="modal__bottom">
                        <span class="error">Не все поля заполнены</span>
                        <button class="button green" @click="addPost()">Добавить</button>
                    </div>
                </Modal>
                <Post v-for="(post) in displayedPosts" :key="post.id" :post="JSON.parse(JSON.stringify(post))" :admin="true"
                    @deleted="onPostDeleted" />
                <div v-if="displayedPosts.length == 0" class="post__item">
                    Постов нет
                </div>
            </div>
        </div>

        <!-- FILEPATH: d:\Lolzteam\frontend\src\components\Main\Main.vue -->
        <!--
        This code block represents a pagination component that allows the user to navigate through pages of content. 
        It includes a previous and next button, as well as page numbers that can be clicked to navigate to a specific page. 
        The current page is highlighted with a different style. The component is implemented using Vue.js directives and event listeners.
        -->
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
                <li :class="{ active: currentPage === 1 }" v-if="totalPages != 1">
                    <a @click="goToPage(1)">1</a>
                </li>
                <li v-if="currentPage > 2">
                    <span>...</span>
                </li>
                <li v-if="currentPage > 1 && currentPage < totalPages - 1 || currentPage == 2 && totalPages > 2 || currentPage == totalPages - 1 && currentPage != 1"
                    :class="{ active: true }">
                    <a @click="goToPage(currentPage)">{{ currentPage }}</a>
                </li>
                <li v-if="totalPages > 1 && currentPage != totalPages && currentPage != totalPages - 1">
                    <span>...</span>
                </li>
                <li :class="{ active: currentPage === totalPages }" v-if="totalPages != 0">
                    <a @click="goToPage(totalPages)">{{ totalPages
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

<!--
This component is responsible for rendering a list of posts. 
It imports the Post and Modal components and uses them to display the posts.
 The component has a data object that contains the currentPage, pageSize, and posts array. 
 The posts array contains objects with properties such as id, title, short_desc, desc, time, and author. 
 The component uses v-for directive to loop through the posts array and display each post using the Post component. 
 The Modal component is used to display a modal window when a post is clicked. 
-->
<script>
import Post from '../Main/Post.vue';
import Modal from '../Modal/Modal.vue';

export default {
    name: 'MMain',
    emits: ['deleted'],
    components: {
        Post,
        Modal
    },
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
            posts: [],
            showModal: false,
            loading: true,
            intervalId: null
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
    mounted() {
        this.fetchPosts();
        this.intervalId = setInterval(() => {
            this.fetchPosts();
        }, 15000); // 15 секунд = 15000 мс
    },
    beforeUnmount() { // замените beforeDestroy на beforeUnmount
        if (this.intervalId) {
            clearInterval(this.intervalId);
        }
    },
    methods: {
        onPostDeleted(id) {
            this.posts = this.posts.filter(post => post.id !== id);
            this.displayedPosts = this.displayedPosts.filter(post => post.id !== id);
        },
        async fetchPosts() {
            try {
                fetch('http://localhost/public/api/posts')
                    .then(response => {
                        if (!response.ok) {
                            this.loading = false;
                            throw new Error('Network response was not ok');
                        }

                        return response.json();
                    })
                    .then(data => {
                        this.posts = data;
                        this.loading = false;
                    })
                    .catch(error => {
                        this.loading = false;
                        console.error('There has been a problem with your fetch operation:', error);
                    });

            } catch (error) {
                console.error('There was an error fetching the posts!', error);
            }



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
        addPost() {
            var title = document.getElementById('title');
            var author = document.getElementById('author');
            var short_desc = document.getElementById('short_desc');
            var description = document.getElementById('description');
            title.classList.remove('error_input');
            author.classList.remove('error_input');
            short_desc.classList.remove('error_input');
            description.classList.remove('error_input');
            if (author.value == '') {
                document.querySelector('.error').style.display = 'block';
                author.classList.add('error_input');
                return;
            }
            if (title.value == '') {
                document.querySelector('.error').style.display = 'block';
                title.classList.add('error_input');

                return;
            }
            if (short_desc.value == '') {
                document.querySelector('.error').style.display = 'block';
                short_desc.classList.add('error_input');
                return;
            }
            if (description.value == '') {
                document.querySelector('.error').style.display = 'block';
                description.classList.add('error_input');
                return;
            }
            document.querySelector('.error').style.display = 'none';
            this.showModal = false;

            this.posts.push({
                id: this.posts.length + 1,
                title: title.value,
                author: author.value,
                short_desc: short_desc.value,
                desc: description.value,
                time: new Date().toLocaleString()

            }
            );
            title.value = '';
            author.value = '';
            short_desc.value = '';
            description.value = '';
        }
    }
};
</script>