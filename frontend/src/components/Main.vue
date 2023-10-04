<template>
    <main>
        <Post v-for="(post, index) in displayedPosts" :key="index" :title="post.title" :short_desc="post.short_desc"
            :time="post.time" />
        <nav>
            <ul class="pagination">
                <li v-bind:class="{ 'non-active': currentPage === 1 }">
                    <a @click="currentPage > 1 ? previousPage() : null">Предыдущая</a>
                </li>
                <li>
                    <a @click="goToPage(1)" :class="{ active: currentPage === 1 }">1</a>
                </li>
                <li v-if="currentPage > 2">
                    <span>...</span>
                </li>
                <li v-if="currentPage > 2 && currentPage < totalPages - 1 || currentPage == 2">
                    <a @click="goToPage(currentPage)" :class="{ active: true }">{{ currentPage }}</a>
                </li>
                <li v-if="totalPages > 1">
                    <span>...</span>
                </li>
                <li>
                    <a @click="goToPage(totalPages)" :class="{ active: currentPage === totalPages }">{{ totalPages
                        }}</a>
                </li>
                <li v-bind:class="{ 'non-active': currentPage >= totalPages }">
                    <a @click="currentPage < totalPages ? nextPage() : null">Следующая</a>
                </li>
            </ul>
        </nav>
    </main>
</template>

<script>
    import Post from './Post.vue';

    export default {
        name: 'MMain',
        components: {
            Post
        },
        data() {
            return {
                currentPage: 1,
                pageSize: 5,
                posts: [
                    { title: 'Post 5', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 6', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 13', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 7', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 8', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 14', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 9', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 150', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 2', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 161', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 3', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 4', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 12', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 5', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 6', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 13', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 7', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 8', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 14', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 9', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 150', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 2', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 161', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 3', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 4', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 12', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 5', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 6', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 13', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 7', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 8', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 14', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 9', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 150', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 2', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 161', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 3', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 4', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 12', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 5', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 6', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 13', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 7', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 8', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 14', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 9', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 150', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 2', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 161', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 3', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 4', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 12', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 5', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 6', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 13', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 7', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 8', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 14', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 9', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 150', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 2', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 161', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 3', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 1', short_desc: 'Description 1', time: 'Time 1' },

                    { title: 'Post 4', short_desc: 'Description 1', time: 'Time 1' },
                    { title: 'Post 12', short_desc: 'Description 1', time: 'Time 1' },
                ],
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

<style>
    nav {
        display: flex !important;
        justify-content: center;
    }

    .pagination {
        list-style: none;
        padding: 0;
        display: flex;
    }

    .pagination li {
        margin: 0 5px;
        border: 1px solid blue;
        padding: 5px;
        border-radius: 5px;
    }

    .pagination a {
        text-decoration: none;
    }

    .pagination a.active {
        font-weight: bold;
    }

    .pagination span {
        margin: 0 5px;
    }

    .non-active {
        color: gray;
        border: 1px solid gray !important;
    }
</style>