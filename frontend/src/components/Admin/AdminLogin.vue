<template>
  <div class="admin">
    <h1>Админ-Панель</h1>
    <form @submit.prevent="login">
      <label>
        Логин:
        <input v-model="text" type="text" id="login" />
      </label>
      <label>
        Пароль:
        <input v-model="password" type="password" id="password" />
      </label>
      <div class="modal__bottom col">
        <span class="error" style="margin-bottom:10px">Не все поля заполнены</span>
        <button type="submit">Войти</button>
      </div>

    </form>
  </div>
</template>
  
<script>



export default {
  data() {
    return {
      text: "",
      password: ""    
    };
  },
  methods: {
    async login() {
      var login = document.getElementById('login');
      var password = document.getElementById('password');

      login.classList.remove('error_input');
      password.classList.remove('error_input');
      if (this.text  == '') {
        document.querySelector('.error').style.display = 'block';
        login.classList.add('error_input');
        return;
      }
      if (this.password == '') {
        document.querySelector('.error').style.display = 'block';
        password.classList.add('error_input');
        return;
      }
      document.querySelector('.error').style.display = 'none';
      this.$cookies.set("adminKey", 'admin');
          window.location.reload();
      try {
        const response = await this.$axios.post("/api/admin/login", {
          password: this.password,
          login: this.login
        });

        if (response.data && response.data.adminKey) {
          this.$cookies.set("adminKey", response.data.adminKey);
          window.location.reload();
        }
      } catch (error) {
        console.error("Ошибка при входе:", error);
      }
    }
  }
};
</script>
  