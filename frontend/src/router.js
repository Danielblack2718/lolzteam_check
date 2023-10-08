// router.js
import { createRouter, createWebHistory } from 'vue-router';
import MMain from './components/Home.vue'; 
import MPost from './components/PostPage.vue'; 
import MAdmin from './components/Admin.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: MMain
  },
  {
    path: '/post/:id',
    name: 'Post',
    component: MPost 
  },
  {
    path: '/admin',
    name: 'Admin',
    component: MAdmin 
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
