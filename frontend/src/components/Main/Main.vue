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
            <div v-else style="width: 100%;">
                <input v-model="searchQuery" placeholder="Поиск..." />

                <span @click="showModal = true;" class="create_post pointer">Добавить пост</span>
                <Modal v-if="showModal" @close="showModal = false" title="Добавить пост">
                    <label for="author">Автор поста</label>
                    <input type="text" id="author" placeholder="Ваше имя" v-model="postForm.author">
                    <label for="title">Заголовок</label>
                    <input type="text" id="title" placeholder="Заголовок" v-model="postForm.title">
                    <label for="short_desc">Краткое описание поста</label>
                    <textarea name="" id="short_desc" placeholder="Краткое описание поста"
                        v-model="postForm.short_desc"></textarea>
                    <label for="description">Описание поста</label>
                    <div style="max-height: 1000px;max-width: 900px;">
                        <QuillEditor v-model="content"></QuillEditor>
                    </div>

                    <div class="modal__bottom">
                        <span class="error">Не все поля заполнены</span>
                        <button class="button green" @click="addPost()">Добавить</button>

                    </div>
                </Modal>

                <Post v-for="(post) in displayedPosts" :key="post.id" :post="JSON.parse(JSON.stringify(post))"
                    @deleted="onPostDeleted" />
                <div v-if="posts.length == 0" class="post__item">
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
import Post from './PostItem.vue';
import Modal from '../Modal/Modal.vue';
import sweetAlertMixin from '@/mixins/sweet-alert-mixin'
import QuillEditor from '../Editor/QuillEditorCustom.vue';
export default {
    name: 'MMain',
    emits: ['deleted'],
    mixins: [sweetAlertMixin],
    components: {
        Post,
        Modal,
        QuillEditor
    },
    props: {
        admin: Boolean
    },
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
            posts: [],
            showModal: false,
            loading: true,
            intervalId: null,
            searchQuery: '',
            postForm: {
                author: '',
                title: '',
                short_desc: '',
                desc: ''
            }
        };
    },
    beforeUnmount() { // замените beforeDestroy на beforeUnmount
        if (this.intervalId) {
            clearInterval(this.intervalId);
        }
    },
    mounted() {
        this.fetchPosts();
        this.userId = this.getOrCreateUserId();
        this.intervalId = setInterval(() => {
            this.fetchPosts();
        }, 15000); // 15 секунд = 15000 мс
        
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
        onPostDeleted(id) {
            this.posts = this.posts.filter(post => post.id !== id);
            this.displayedPosts = this.displayedPosts.filter(post => post.id !== id);
        },
        deletePost(id) {
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
            const { author, title, short_desc } = this.postForm;
            var description = document.querySelector('.ql-editor');
            console.log(description)
            if (author === '' || title === '' || short_desc === '' || description.innerHTML === '<p><br></p>') {
                document.querySelector('.error').style.display = 'block';
                return;
            }
            document.querySelector('.error').style.display = 'none';
            this.showModal = false;

            try {
                fetch('http://localhost/public/api/post', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        title: title,
                        author: author,
                        short_desc: short_desc,
                        desc: description.innerHTML,
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
                        this.showSuccessMessage("Успех", "Вы успешно добавили запись")
                        this.posts.push({
                            id: data.id,
                            title: title,
                            author: author,
                            short_desc: short_desc,
                            desc: description.innerHTML,
                            created_at: data.created_at,
                            user_id: this.userId,
                            comments:[]
                        }
                        );
                    })
                    .catch(error => {
                        this.showErrorMessage("Ошибка", "При добавлении произошла ошибка");
                        console.error('There has been a problem with your fetch operation:', error);
                    });
            } catch (error) {
                this.showErrorMessage("Ошибка", "При добавлении произошла ошибка");
                console.error('There was an error fetching the posts!', error);
            }
        }
    },
    computed: {
        totalPages() {
            return Math.ceil(this.filteredPosts.length / this.pageSize);
        },
        filteredPosts() {
            const searchQuery = this.searchQuery.toLowerCase();
            return this.posts.filter(post =>
                post.title.toLowerCase().includes(searchQuery) ||
                post.author.toLowerCase().includes(searchQuery) ||
                post.short_desc.toLowerCase().includes(searchQuery) ||
                post.desc.toLowerCase().includes(searchQuery)
            );
        },
        displayedPosts() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            return this.filteredPosts.slice(start, end);
        }
    },
};
</script>