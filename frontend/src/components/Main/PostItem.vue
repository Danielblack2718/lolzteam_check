<template>
  <div class="post__item" :key="localPost.id" v-if="!isPostDeleted" @click="!admin ? goToPost(localPost.id) : null">
    <span class="post__title">{{ localPost.title }}</span>
    <span class="post__short-desc">{{ localPost.short_desc }}</span>
    <div class="post__bottom">
      <span class="bottom__reviews">Кол-во отзывов: {{ localPost.comments.length }}</span>
      <span class="bottom__author">Автор: {{ localPost.author }}</span>
      <span class="bottom__time">{{ localPost.created_at }}</span>
    </div>
    <div class="admin_buttons" v-if="admin || userId == localPost.user_id">
      <div class="button red" @click="deletePostModal($event)" v-if="admin || userId == localPost.user_id">Удалить</div>
      <div class="button green" @click="editPostModal($event)" v-if="admin || userId == localPost.user_id">Редактировать
      </div>
      <div class="button gray" @click="goToPost(localPost.id)" v-if="admin">Посмотреть</div>
    </div>
  </div>
  <Modal v-if="showModal" @close="showModal = false" title="Удалить пост">
    <label for="">Вы действительно хотите удалить пост?</label>
    <div class="modal__bottom">
      <button class="button red" @click="deletePost()">Удалить</button>
    </div>
  </Modal>
  <Modal v-if="showEditModal" @close="cancelEdit" title="Редактировать пост">
    <label for="author">Автор поста</label>
    <input type="text" id="author" placeholder="Ваше имя" v-model="tempAuthor">
    <label for="title">Заголовок</label>
    <input type="text" id="title" placeholder="Заголовок" v-model="tempTitle">
    <label for="short_desc">Краткое описание поста</label>
    <textarea name="" id="short_desc" placeholder="Краткое описание поста" v-model="tempShortDesc"></textarea>
    <label for="description">Описание поста</label>
    <div style="max-height: 1000px;max-width: 900px;">
      <QuillEditor ref="quillEditor" v-model="tempContent"></QuillEditor>
    </div>
    <div class="modal__bottom">
      <span class="error" id="error">Не все поля заполнены</span>
      <button class="button green" @click="confirmEdit()">Сохранить</button>
    </div>
  </Modal>
</template>

<script>
import Modal from '../Modal/Modal.vue';
import sweetAlertMixin from '../../mixins/sweet-alert-mixin'
import QuillEditor from '../Editor/QuillEditorCustom.vue';
export default {
  name: 'MMain',
  mixins: [sweetAlertMixin],
  methods: {
    confirmEdit() {
      this.localPost.author = this.tempAuthor;
      this.localPost.title = this.tempTitle;
      this.localPost.short_desc = this.tempShortDesc;
      this.localPost.desc = this.tempContent;
      this.editPost();
      this.showEditModal = false;
    },
    cancelEdit() {
      this.showEditModal = false;
    },
    setQuillContent(content) {
      this.$nextTick(() => {
        const quillEditor = document.querySelector('.ql-editor');
        if (quillEditor) {
          quillEditor.innerHTML = content;
        }
      });
    },
    editPostModal(e) {
      e.stopPropagation();
      this.showEditModal = true;
      this.tempAuthor = this.localPost.author;
      this.tempTitle = this.localPost.title;
      this.tempShortDesc = this.localPost.short_desc;
      this.tempContent = this.localPost.desc;
      this.setQuillContent(this.localPost.desc);
    },
    deletePostModal(e) {
      e.stopPropagation();
      this.showModal = true;
    },
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
    goToPost(postId) {

      this.$router.push({ path: `/post/${postId}` });
    },
    deletePost() {
      try {
        fetch(`http://localhost/public/api/post/${this.localPost.id}`, {
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
            this.showSuccessMessage("Успех", "Вы успешно удалили запись")
            this.$emit('deleted', this.localPost.id);
            this.showModal = false;
          })
          .catch(
            error => console.log(error)
          );
      } catch (e) {
        this.showErrorMessage("Ошибка", "При удалении произошла ошибка");
        console.log(e);
      }

    },
    editPost() {
      this.showEditModal = false;
      const author = this.tempAuthor;
      const title = this.tempTitle;
      const short_desc = this.tempShortDesc;
      const desc = document.querySelector('.ql-editor').innerHTML;
      console.log(desc)
      if (author == '' || title == '' || short_desc == '' || desc == '') {
        document.getElementById('error').style.display = 'block';
        return;
      }
      try {
        fetch(`http://localhost/public/api/post/${this.localPost.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json;charset=utf-8'
          },
          body: JSON.stringify({
            author: author,
            title: title,
            short_desc: short_desc,
            desc: desc
          })
        })
          .then(response => response.json())
          .then(result => {
            console.log(result)
            const error_element = document.getElementById('error')
            if (error_element) {
              error_element.style.display = 'none';
            }
            this.showSuccessMessage("Успех", "Вы успешно обновили запись")
            this.localPost.author = author;
            this.localPost.title = title;
            this.localPost.short_desc = short_desc;
            this.localPost.desc = desc;
          })
          .catch(error => console.log(error));
      }
      catch (e) {
        this.showErrorMessage("Ошибка", "При обновлении произошла ошибка");
        console.log(e);
      }
    }
  },
  components: {
    Modal,
    QuillEditor
  },
  props: {
    post: Object,
    admin: Boolean,
  },
  mounted() {
    this.userId = this.getOrCreateUserId();
  },
  data() {
    return {
      localPost: this.post,
      showModal: false,
      isPostDeleted: false,
      showEditModal: false,
      adminKey: this.$cookies.get("adminKey"),
      userId: null,
      content: 'авваыаываыва',
      tempContent: '',
      tempAuthor: '',
      tempTitle: '',
      tempShortDesc: '',
    };
  }
}
</script>
