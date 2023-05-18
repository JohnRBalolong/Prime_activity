<template>
  <div class="registrationBox" v-show="registrationBox">
    <img class="user" src="https://i.ibb.co/yVGxFPR/2.png" height="100px" />
    <div class="row justify-content-center">
    <h3>Registration</h3>

    <div class="p-inputgroup mb-3">
      <span class="p-inputgroup-addon">
        <i class="pi pi-user"></i>
      </span>
      <InputText placeholder="Last Name" :class="{ 'p-invalid': submitted && !lastName }" v-model="lastName" />
      <span style="margin-left: 3px"></span>
      <InputText placeholder="First Name" :class="{ 'p-invalid': submitted && !firstName }" v-model="firstName" />
      <Dropdown
        style="margin-left: 3px; width: 10px;"
        v-model="selectedSuffix"
        :options="suffix"
        optionLabel="name"
        placeholder="Suffix"
        
      />
    </div>
    <div class="p-inputgroup mb-3" >
      <span class="p-inputgroup-addon">
        <i class="pi pi-at"></i>
      </span>
      <InputText placeholder="Email address" type="email" :class="{ 'p-invalid': submitted && !email }" v-model="email" />
    </div>
    <div class="p-inputgroup mb-3" >
      <span class="p-inputgroup-addon">
        <i class="pi pi-user"></i>
      </span>
      <InputText placeholder="User Name" :class="{ 'p-invalid': submitted && !username }" v-model="username" />
    </div>

    
    <div class="p-inputgroup mb-3" >
  <span class="p-inputgroup-addon" style="width: 40px; height: 42px; border-radius: 4px 0 0 4px; border-left: 0;">
    <i class="pi pi-key"></i>
  </span>
  <Password
  placeholder="Password"
  :class="{ 'p-invalid': submitted && !password }"
  no-auto-clear
  v-model="password"
  :strength-display="showStrength"
  
  size="30"

  toggleMask
/>
</div>


<div class="p-inputgroup  mb-3" >
  <span class="p-inputgroup-addon" style="width: 40px; height: 42px; border-radius: 4px 0 0 4px; border-left: 0;">
    <i class="pi pi-key"></i>
  </span>
  <Password placeholder="Confirm Password" :class="{ 'p-invalid': !confirmpassword || (confirmpassword !== password)}" no-auto-clear v-model="confirmpassword" :strength-display="showStrength"  toggleMask/>
</div>


<Button
  id="btn"
  class="p-button-rounded"
  :class="[{'p-invalid': submitted && (!lastName || !firstName || !email || !username || !password || !confirmpassword || (confirmpassword !== password))}]"
  style="
    margin-top: 15px;
    width: 270px;
    margin-left: auto;
    margin-right: auto;
    display: block;
  "
  type="submit"
  label="Register"
  @click="validateForm"
/>
    <br />
    <p
  id="color-hover"
  style="cursor:pointer; color: #5E26D5; text-align: center; margin-top: 10px;"
  @click="goToSignIn"
>
  Sign-in
</p>


    <backSignUp v-if="SignUp" />

  </div>
  </div>

  <Toast :style="{ 'top': '50px', 'left': '50%', 'transform': 'translateX(-50%)', 'max-width': '400px' }" />


</template>

<script>


import axios from "axios"; // Add this line
import backSignUp from "../App.vue";
import InputText from "primevue/inputtext";
import Dropdown from "primevue/dropdown";
import Password from "primevue/password";
import Button from "primevue/button";
import Toast from "primevue/toast";

// import { watch } from "vue";

import { ref } from "vue";

export default {
  
  components: {
    InputText,
    Dropdown,
    Password,
    Button,
    backSignUp,
    Toast,
  },
  emits: ['showLogin'],
  name: "RegistrationForm",

  methods: {
    
    goToSignIn() {
      this.$emit("showLogin");
    },
    // togglePasswordVisibility() {
    //   this.inputType = this.inputType === "password" ? "text" : "password";
    // },
    async validateForm() {
      this.submitted = true;

      

      if (
        !this.lastName ||
        !this.firstName ||
        !this.email ||
        !this.username ||
        !this.password ||
        !this.confirmpassword ||
        this.confirmpassword !== this.password
      ) {
        return;
      } else {
        try {
  const response = await axios.post("http://127.0.0.1:8000/api/userdata", {
    last_name: this.lastName,
    first_name: this.firstName,
    suffix: this.selectedSuffix ? this.selectedSuffix.code : "",
    email_address: this.email,
    username: this.username,
    password: this.password,
  });

  // console.log(response.data);

  this.$toast.add({
  severity: 'success',
  summary: 'Registered Successfully',
  detail: response.data.message,
  life: 3000,
  onHidden: () => {
    this.$emit("showLogin");
  }
});
} catch (error) {
  // console.error("Error while registering:", error);
  
  if (error.response) {
    const errorData = error.response.data.error || {};
    const emailErrors = errorData.email_address || [];
    const usernameErrors = errorData.username || [];
    const passwordErrors = errorData.password || [];

    let errorMessage = "";

    if (emailErrors.length > 0) {
      errorMessage += emailErrors[0] + " ";
    }

    if (usernameErrors.length > 0) {
      errorMessage += usernameErrors[0] + " ";
    }

    if (passwordErrors.length > 0) {
      errorMessage += passwordErrors[0];
    }

    if (!errorMessage) {
      errorMessage = "An error occurred while registering.";
    }

    this.$toast.add({
      severity: 'error',
      summary: 'Registration Error:',
      detail: errorMessage,
      life: 5000 // Set the toast message display time
    });
  }
}




      }
    },
  },

  setup() {
    const lastName = ref("");
    const firstName = ref("");
    const selectedSuffix = ref(null);
    const email = ref("");
    const username = ref("");
    const password = ref("");
    const confirmpassword = ref("");
    const showStrength = ref(false);
    const suffix = [
      { name: "Suffix", code: "" },
      { name: "Jr.", code: "Jr." },
      { name: "Sr.", code: "Sr." },
      { name: "II", code: "II" },
      { name: "III", code: "III" },
      { name: "IV", code: "IV" },
    ];

    const submitted = ref(false);

    return {
      lastName,
      firstName,
      selectedSuffix,
      email,
      username,
      password,
      confirmpassword,
      showStrength,
      suffix,
      SignUp: false,
      registrationBox: true,
      inputType: "password",
      submitted,
    };
  },
};
</script>




<style>


.registrationBox {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 500px;
  min-height: 150px;
  background: #000000;
  border-radius: 10px;
  padding: 40px;
  box-sizing: border-box;
}



@media only screen and (max-width: 600px) {
  .registrationBox {
    width: 90%;
    max-width: 400px;
  }
  .p-inputgroup {
    width: 300px;
  }
}

.user {
  margin-bottom: 20px;
}

h3 {
  color: #ffffff;
  margin-bottom: 20px;
}

.p-inputgroup-addon {
  background-color: #0078d4;
  color: #ffffff;
}


.p-button-rounded {
  background-color: #0078d4;
  border-color: #0078d4;
  color: #ffffff;
  font-size: 14px;
  font-weight: bold;
}

.p-button-rounded:hover {
  background-color: #005a9e;
  border-color: #005a9e;
}


@media only screen and (max-width: 600px) {
.p-inputgroup {
width: 100%;
}
}

.p-invalid {
border: 1px solid red !important;
}
input.p-inputtext.p-component.p-password-input {
    width: 100%;
}
</style>
