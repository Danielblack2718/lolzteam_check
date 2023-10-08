<template>
  <header>
    <div>
      <router-link to="/" class="header__back" v-if="canGoBack">Вернуться назад</router-link>
    </div>

    <div class="header__content">
      <a href="/"><img src="../assets/img/logo.png" width="25" alt=""></a>
      <h1>{{ title }}</h1>
    </div>
    <div>
      <button @click="logout" class="header__logout" v-if="adminKey">Выход</button>
    </div>

  </header>
</template>

<script>

import sweetAlertMixin from '@/mixins/sweet-alert-mixin'
export default {
  name: 'MHeader',
  mixins: [sweetAlertMixin],
  props: {
    title: String
  },
  data() {
    return {
      adminKey: this.$cookies.get("adminKey")
    };
  },
  computed: {
    canGoBack() {

      return this.$route.fullPath !== '/';
    }
  },
  methods: {
    logout() {
      // Реализуйте здесь логику выхода, например, удаление токена аутентификации
      // и перенаправление пользователя на страницу авторизации или главную страницу.
      // Пример:
      this.showSuccessMessage('Вы вышли из системы');
      this.$cookies.remove("adminKey"); // Удаление токена (если используете cookies)
      this.$router.push('/'); // Перенаправление на главную страницу
    }
  }
}
</script>

<style scoped>
.header-buttons {
  display: flex;
  align-items: center;
  gap: 10px;
}
</style>
