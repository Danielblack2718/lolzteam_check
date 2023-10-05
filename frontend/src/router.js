// router.js
import { createRouter, createWebHistory } from 'vue-router';
import MMain from './components/Home.vue'; // Импортируйте ваши компоненты
import MPost from './components/Post.vue'; // Импортируйте ваши компоненты

const routes = [
  {
    path: '/',
    name: 'Home',
    component: MMain
  },
  {
    path: '/post/:id',
    name: 'Post',
    component: MPost // Путь до вашего компонента поста
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
