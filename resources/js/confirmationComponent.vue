<template>
<div v-if="allowed" class="gradient-form max-w-md text-center m-auto bg-white flex flex-col items-center justify-center h-screen"> 
  <div v-if="entry == null">
    <h1 class="text-2xl mb-2">Do you wish to enter? You can only enter once a day.</h1>
    <button @click="confirm" class="input-form btn-submit inline mr-3 rounded-xl">Yes</button>
    <button @click="decline" class="input-form btn-submit inline rounded-xl">No</button>
    
  </div>
  <div v-if="entry">
    <p class="text-4xl underline mb-2">Welcome to the group</p>
    <button @click="decline" class="input-form btn-submit inline rounded-xl">Home</button>
  </div>
  <div v-if="entry == false">
    <p class="text-4xl underline mb-2">You already entered today</p>
    <p class="text-2xl mb-2">Come back tomorrow</p>
    <br>
    <button @click="decline" class="input-form btn-submit inline rounded-xl">Home</button>
  </div>
 <!--  <div >You already entered today {{entry}}<button @click="decline">Go To Home Page</button></div> -->
</div>
</template>

<script>
export default {
  props: ['allowed'],
  data() {
    return {
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      entry: null,
    };
  },
  methods: {
    confirm() {
      let currentObj = this;
      axios
        .get("/confirmation")
        .then(function (response) {
          console.log(response.data)
          if (response.data == true) {
              currentObj.entry = true;
          } else {
              currentObj.entry = false
          }
        })
        .catch(function (error) {
          console.log(error.response.data)
        });
    },
    decline() {
      window.location.reload()
    }
  },
};
</script>

<style>
</style>