<template>
  <div class="post__item" :key="localPost.id" v-if="!isPostDeleted" @click="!admin ? goToPost(localPost.id) : null">
    <span class="post__title">{{ localPost.title }}</span>
    <span class="post__short-desc">{{ localPost.short_desc }}</span>
    <div class="post__bottom">
      <span class="bottom__author">{{ localPost.author }}</span>
      <span class="bottom__time">{{ localPost.time }}</span>
    </div>
    <div class="admin_buttons" v-if="admin">
      <div class="button red" @click="showModal = true;">Удалить</div>
      <div class="button green" @click="showEditModal = true">Редактировать</div>
      <div class="button gray" @click="goToPost(localPost.id)">Посмотреть</div>
    </div>
  </div>
  <Modal v-if="showModal" @close="showModal = false" title="Удалить пост">
    <label for="">Вы действительно хотите удалить пост?</label>
    <div class="modal__bottom">
      <button class="button red" @click="deletePost()">Удалить</button>
    </div>
  </Modal>
  <Modal v-if="showEditModal" @close="showEditModal = false" title="Редактировать пост">
    <label for="author">Автор поста</label>
    <input type="text" id="author" placeholder="Ваше имя" :value="localPost.author">
    <label for="title">Заголовок</label>
    <input type="text" id="title" placeholder="Заголовок" :value="localPost.title">
    <label for="short_desc">Краткое описание поста</label>
    <textarea name="" id="short_desc" placeholder="Краткое описание поста" :value="localPost.short_desc"></textarea>
    <label for="description">Описание поста</label>
    <textarea name="" id="description" placeholder="Описание поста" :value="localPost.desc"></textarea>
    <label for="time"></label>
    <input type="date" :value="localPost.time" id="time">
    <div class="modal__bottom">
      <span class="error">Не все поля заполнены</span>
      <button class="button green" @click="editPost()">Сохранить</button>
    </div>
  </Modal>
</template>

<script>
import Modal from '../Modal/Modal.vue';

export default {
  name: 'MMain',
  methods: {
    goToPost(postId) {
      this.$router.push({ path: `/post/${postId}` });
    },
    deletePost() {
      try {
        fetch(`http://localhost/public/api/post/${this.localPost.id}`, {
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
            this.$emit('deleted', this.localPost.id);
            this.showModal = false;
          })
          .catch(error => console.log(error));
      } catch (e) {
        console.log(e);
      }

    },
    editPost() {
      this.showEditModal = false;
      this.localPost.author = document.getElementById('author').value;
      this.localPost.title = document.getElementById('title').value;
      this.localPost.short_desc = document.getElementById('short_desc').value;
      this.localPost.desc = document.getElementById('description').value;
      this.localPost.time = document.getElementById('time').value;

      // Дополнительная логика для сохранения изменений
    }
  },
  components: {
    Modal
  },
  props: {
    post: Object,
    admin: Boolean,
  },
  data() {
    return {
      localPost: this.post,
      showModal: false,
      isPostDeleted: false,
      showEditModal: false,
      adminKey: this.$cookies.get("adminKey")
    };
  }
}
</script>
