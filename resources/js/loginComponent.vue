<template>
  <div v-if="display" class="gradient-form max-w-md text-center m-auto flex flex-col items-center justify-center h-screen">
    <div class="text-4xl font-bold underline mb-5 ">
      <h1 v-if="!this.switch">Create an account</h1>
      <h1 v-else>Login</h1>
    </div>
    
    <div class="text-left p-1 rounded text-2xl">
      <p v-if="errorText" class="text-center bg-red-500 rounded-lg mb-2">
        <b>{{ errorText }}</b>
      </p> 
      <form @submit.prevent @keydown.enter="$event.preventDefault()" v-if="!this.switch">
        <input type="hidden" name="_token" :value="csrf" />

        <label class="label-form">First Name</label>
        <input class="input-form" type="text" v-model="firstname" />
        <label class="label-form">Last Name</label>
        <input class="input-form" type="text" v-model="lastname" />
        <label class="label-form">Email</label>
        <input class="input-form" type="email" v-model="email" />
        <label class="label-form">Password</label>
        <input class="input-form" type="password" v-model="password" />
        <label class="label-form">Phone Number</label>
        <input class="input-form" type="tel" v-model="phonenumber" />
        <div class="flex items-center my-4">
          <input class="input-form" type="checkbox" v-model="terms" />
          <label class="label-form ml-2 text-sm font-medium">Accept terms of services</label>
        </div>
        <div class="flex items-center mb-4">
          <input class="input-form" type="checkbox" v-model="newsletter" />
          <label class="label-form ml-2 text-sm font-medium">Opt in to our newsletter</label>
        </div>
        <div>
          <input class="input-form btn-submit gradient-button" type="submit" value="Register →" @click="checkFormRegister()" />
          <br>
          <p class="text-sm italic mt-5" @click="switchForm()">Already have an account? <span class="btn-submit inline p-1">Login</span></p>
        </div>
      </form>
      <form @submit.prevent @keydown.enter="$event.preventDefault()" v-if="this.switch">
        <input class="input-form" type="hidden" name="_token" :value="csrf" />
        <label class="label-form">Email</label>
        <input class="input-form" type="email" v-model="email" />
        <label class="label-form">Password</label>
        <input class="input-form" type="password" v-model="password" />
        <div>
          <input class="input-form btn-submit gradient-button" type="submit" value="Login →" @click="checkFormLogin()" />
          <br>
          <p class="text-sm italic mt-5" @click="switchForm()">Need an account? <span class="btn-submit inline p-1">Register</span></p>
        </div>
      </form>
    </div>
  </div>

  <Confirmation :allowed="confirmationDisplay" />
</template>

<script>
import Confirmation from "./confirmationComponent.vue";
export default {
  components: { Confirmation },
  data() {
    return {
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      firstname: "",
      lastname: "",
      email: "",
      password: "",
      phonenumber: "",
      terms: false,
      newsletter: false,
      errorText: "",
      display: true,
      confirmationDisplay: false,
      switch: false,
    };
  },

  methods: {
    checkFormRegister() {
      if (
        !this.firstname ||
        !this.lastname ||
        !this.email ||
        !this.password ||
        !this.phonenumber
      ) {
        return (this.errorText = "Missing Fields");
      } else {
        this.errorText = "";
      }
      if (!this.terms){
        return (this.errorText = "Accept terms of service");
      } else {
        this.errorText = "";
      }

      if (this.password.length <= 7 || this.password.length >= 60) {
        return (this.errorText = "Password Length Incorrect");
      } else {
        this.errorText = "";
      }
      if (this.firstname.length > 150 || this.lastname.length > 150) {
        return (this.errorText = "One of the names are too long");
      } else {
        this.errorText = "";
      }
      if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) {
        return (this.errorText = "Email not valid");
      } else {
        this.errorText = "";
      }
      if (this.email.length >= 319) {
        return (this.errorText = "Email too long");
      } else {
        this.errorText = "";
      }
      if (
        !/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/.test(
          this.phonenumber
        )
      ) {
        return (this.errorText = "Phone number not valid");
      } else {
        this.errorText = "";
      }
      if (this.phonenumber.length > 15) {
        return (this.errorText = "Phone number is too long");
      } else {
        this.errorText = "";
      }

      if (!this.errorText) {
        let currentObj = this;
        axios
          .post("/register", {
            params: {
              first_name: this.firstname,
              last_name: this.lastname,
              email: this.email,
              password: this.password,
              phone_number: this.phonenumber,
              terms: this.terms,
              news_letter: this.newsletter,
            },
          })
          .then(function (response) {
            console.log(response.data)
            if (response.data == true) {
              currentObj.display = false;
              currentObj.confirmationDisplay = true;
            } else {
              currentObj.errorText = "An account may have aready been registered try again"
            }
          })
          .catch(function (error) {
            console.log(error.response.data)
          });
      }
    },
    checkFormLogin() {
      if (!this.email || !this.password) {
        
        return (this.errorText = "Missing Fields");
      } else {
        this.errorText = "";
      }
      if (!this.errorText) {
        let currentObj = this;
        axios
          .post("/login", {
            params: {
              email: this.email,
              password: this.password,
            },
          })
          .then(function (response) {
            console.log(response.data)
            if (response.data == true) {
              currentObj.display = false;
              currentObj.confirmationDisplay = true;
            } else {
              currentObj.errorText = "Some thing went wrong. Try again."
            }
          })
          .catch(function (error) {
            console.log(error.response.data)
          });
      }
    },
    switchForm() {
      this.switch = !this.switch;
    }
  },
};
</script>

<style>



</style>