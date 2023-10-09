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
        <span class="error unauth" style="margin-bottom:10px">Неправильный логин или пароль</span>
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
      var loginInput = document.getElementById('login');
      var passwordInput = document.getElementById('password');

      loginInput.classList.remove('error_input');
      passwordInput.classList.remove('error_input');
      if (loginInput.value == '') {
        document.querySelector('.error').style.display = 'block';
        loginInput.classList.add('error_input');
        return;
      }
      if (passwordInput.value == '') {
        document.querySelector('.error').style.display = 'block';
        passwordInput.classList.add('error_input');
        return;
      }
      const error_unauth = document.querySelector('.error.unauth');
      if (error_unauth) error_unauth.style.display = 'none';
      document.querySelector('.error').style.display = 'none';
      try {
        const response = await this.$axios.post("http://localhost:80/public/api/admin/login", {
          login: loginInput.value,
          password: passwordInput.value
        }, {
          headers: {
            'Content-Type': 'application/json'
          }
        });
        if (response.data && response.data['admin_key']) {
          this.$cookies.set("adminKey", response.data['admin_key']);
          window.location.reload();
        }
        else {
          document.querySelector('.error.unauth').style.display = 'block';
        }
      } catch (error) {

        console.error("Ошибка при входе:", error);
        document.querySelector('.error.unauth').style.display = 'block';
      }
    }
  }

};
</script>
  