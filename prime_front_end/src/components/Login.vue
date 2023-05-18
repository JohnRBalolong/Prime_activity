<template>
    <div class="login-background">
    <div class="loginBox" v-show="showLoginBox">
      <img class="user" src="https://i.ibb.co/yVGxFPR/2.png" height="100px">
      <div class="row justify-content-center">
        <h3>Sign in here</h3>
        <div class="p-inputgroup mb-4">
          <span class="p-inputgroup-addon">
            <i class="pi pi-user"></i>
          </span>
          <InputText placeholder="Username" :class="{ 'p-invalid': formInvalid && !username }" v-model="username" />
        </div>
        <div class="p-inputgroup ">
          <span class="p-inputgroup-addon">
            <i class="pi pi-key"></i>
          </span>
          <Password  placeholder="Password" no-auto-clear v-model="password" :strength-display="showStrength" :class="{ 'p-invalid': formInvalid && !password }" toggleMask/>
        </div>
        
        <!-- <Toast ref="toast" /> to fix-->
    <Button style="margin-top: 15px; width: 270px; border-radius: 20px;" :icon="formSubmitted ? 'pi pi-check' : ''" aria-label="Submit" :label="formSubmitted ? 'Submitted' : 'Submit'" :disabled="formSubmitted" @click="submitForm" />
  
    <a style="color:gray; text-decoration: none; margin-top: 10px; text-align: center;" href="#">Forget Password<br> </a>
  
    <p id="color-hover" style="cursor:pointer; color: #5E26D5; text-align: center; margin-top: 10px;" @click="showRegistration = true; showLoginBox = false">Sign-Up</p>
  
    <div class="social-icons">
      <a style="text-decoration: none;" href="#" class="pi pi-github"></a>
      <a style="text-decoration: none;" href="#" class="pi pi-google"></a>
      <a style="text-decoration: none;" href="#" class="pi pi-facebook"></a>
      <a style="text-decoration: none;" href="#" class="pi pi-linkedin"></a>
    </div>
  </div>
  </div>
  
  <div class="gif-container" v-show="showGif">
    <img :src="gif" alt="Loading gif" />
  </div>
  
  <registration v-if="showRegistration" @showLogin="toggleLoginAndRegistration" />
</div>

<Toast :style="{ 'top': '50px', 'left': '50%', 'transform': 'translateX(-50%)', 'max-width': '400px' }" />

  </template>
  
  <script>
  /* eslint-disable vue/multi-word-component-names */
  import axios from 'axios';
  import Registration from "./register.vue";
  import InputText from "primevue/inputtext";
  import Password from "primevue/password";
  import Button from 'primevue/button';
  import gif from "@/assets/ezgif.com-crop.gif";
  import Toast from "primevue/toast";
  
  
  export default {
    components: {
      InputText,
      Password,
      Button,
      Registration,
      Toast,
    },
    mounted() {
    document.body.classList.add('login-background');
  },
  beforeUnmount() {
    document.body.classList.remove('login-background');
  },
    name: "Login",
    data() {
      return {
        username: "",
        password: "",
        showStrength: false,
        formInvalid: false,
        formSubmitted: false,
        showRegistration: false,
        showLoginBox: true,
        showGif: false,
        gif: gif,
      };
    },
    methods: {
      toggleLoginAndRegistration() {
        this.showLoginBox = true;
        this.showRegistration = false;
      },
      submitForm() {
  if (!this.username || !this.password) {
    this.formInvalid = true;
    return;
  }

  axios.post('http://127.0.0.1:8000/api/login', {
    username: this.username,
    password: this.password
  })
  .then(response => {
    response,
    this.showGif = true;
    // Handle successful login
    setTimeout(() => {
      sessionStorage.setItem('isAuthenticated', true);
      this.$router.push({ name: 'Dashboard' });
    }, 2000);
  })
  .catch(error => {
    // Handle login error
    if (!error.response) {
      const errorMessage = "Unable to connect to server. Please check your internet connection.";

      this.$toast.add({
        severity: 'error',
        summary: 'Login Error:',
        detail: errorMessage,
        life: 5000 // Set the toast message display time
      });
    }
    else if (error.response.status === 401) {
      const errorData = error.response.data || {};
      const errorMessage = errorData.error || "An error occurred while login.";

      this.$toast.add({
        severity: 'error',
        summary: 'Login Error:',
        detail: errorMessage,
        life: 5000 // Set the toast message display time
      });
    }
    else if (error.response.status === 422) {
      const errorMessage = "Invalid username or password"

      this.$toast.add({
        severity: 'error',
        summary: 'Login Error:',
        detail: errorMessage,
        life: 5000 // Set the toast message display time
      });
    }
  });
}

    },
  };
  </script >
  
  
  <style>

  .p-inputgroup {
    display: flex;
    align-items: stretch;
    width: 100%;
}
  
  
  .p-inputtext.p-invalid {
    border-color: red !important;
  }
  
  .social-icons {
    display: flex;
    justify-content: center;
  }
  
  .social-icons a {
    margin-right: 10px;
    margin-left: 10px;
    font-size: 20px;
    margin-right: 10px;
    color: #fff;
  }
  
  #color-hover:hover{
    color: #00ffff !important;
  
  }
  a:hover {
    color: #00ffff !important;
  }
  
  
  .user {
    height: 100px;
    margin: 0 auto;
    display: block;
    margin-bottom: 20px;
  }
  h3 {
    margin: 0;
    padding: 0 0 20px;
    color: #59238F;
    text-align: center;
  }
  
  .login-background {
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: url(https://i.ibb.co/VQmtgjh/6845078.png) no-repeat center center fixed;
    background-size: cover;
  }
/* 
  body {
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: url(https://i.ibb.co/VQmtgjh/6845078.png) no-repeat center center fixed;
    background-size: cover;
  } */

  .loginBox {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    width: 350px;
    min-height: 200px;
    background: #000000;
    border-radius: 10px;
    padding: 40px;
    box-sizing: border-box;
  }
  
  .gif-container {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
  }
  
  .gif-container img {
    width: 150px;
    height: auto;
  }
  </style>
  