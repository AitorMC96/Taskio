<template>
    <div>
        <!-- Formulari per fer login d'usuari-->
        <form name="usuari-form">
            <!-- Camp per demanar el nom de l'usuari -->
            <div class="mb-3">
                <label for="firstname">Escriu el nom de l'usuari: </label>
                <input id="firstname" type="text" v-model="input.firstname" />
            </div>
            <!-- Camp per demanar els cognoms de l'usuari -->
            <div class="mb-3">
                <label for="lastname">Escriu els cognoms de l'usuari: </label>
                <input id="lastname" type="text" v-model="input.lastname" />
            </div>
            <!-- Camp per demanar el correu de l'usuari -->
            <div class="mb-3">
                <label for="email">Escriu la contrasenya de l'usuari: </label>
                <input id="email" type="text" v-model="input.email" />
            </div>
            <!-- Camp per demanar el rol de l'usuari -->
            <div class="mb-3">
                <label for="role">Escriu el rol de l'usuari: </label>
                <input id="role" type="text" v-model="input.role" />
            </div>
            <!-- Camp per demanar la contrasenya de l'usuari -->
            <div class="mb-3">
                <label for="password">Escriu la contrasenya de l'usuari: </label>
                <input id="password" type="password" v-model="input.password" />
            </div>
            <!-- Botó per fer la creació d'usuari -->
            <button class="btn btn-outline-dark" type="submit">Crear usuari</button>
        </form>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>