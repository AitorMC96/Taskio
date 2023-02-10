<template>
    <!-- Formulari per fer login d'usuari-->
    <form name="login-form" >
      <!-- Camp per demanar el correu -->
      <div class="mb-3">
        <label for="email">Correu electrònic: </label>
        <input id="email" type="text" v-model="input.email" />
      </div>
      <!-- Camp per demanar la contrasenya -->
      <div class="mb-3">
        <label for="password">Contrasenya: </label>
        <input id="password" type="password" v-model="input.password" />
      </div>
      <!-- Botó per fer el login -->
      <button class="btn btn-outline-dark" type="submit" v-on:click.prevent = "login()">Login</button>
      <!-- <p>El correu és: {{ input.email }}</p> -->
      <!-- <p>La contrasenya és: {{ input.password }}</p> -->
    </form>
    <h3>Output: {{ this.output }}</h3>
</template>

<script>
    /*import { SET_AUTHENTICATION, SET_USERNAME } from "../store/storeconstants";
    export default {
        name: 'LoginView',
        data(){
            return{
                input:{
                    email: "",
                    password: ""
                },
                output: "",
            }
        },
        methods:{
            login(){
                // Comprovem que s'han omplert els camps de correu i contrasenya
                if (this.input.username != "" || this.input.password != "") {
                    this.output = "Authentication complete"
                    //stores true to the set_authentication and username to the set_username 
                    this.$store.commit(`auth/${SET_AUTHENTICATION}`, true);
                    this.$store.commit(`auth/${SET_USERNAME}`, this.input.username);
                    this.output = "Authentication complete."
                    this.$router.push('/home')
                } else {
                    this.$store.commit(`auth/${SET_AUTHENTICATION}`, false);
                    this.output = "Username and password can not be empty"
                }
            }
        },
    }*/
</script>