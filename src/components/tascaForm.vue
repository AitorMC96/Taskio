<template>
    <div>
        <!-- Formulari per fer login d'usuari-->
        <form name="usuari-form" >
            <!-- Camp per demanar el nom de la tasca -->
            <div class="mb-3">
                <label for="firstname">Escriu el nom de l'usuari: </label>
                <input id="firstname" type="text" v-model="input.firstname" />
            </div>
            <!-- Camp per demanar l'ID de l'usuari/s responsables de la tasca -->
            <div class="mb-3">
                <label for="lastname">Escriu els cognoms de l'usuari: </label>
                <input id="lastname" type="text" v-model="input.lastname" />
            </div>
            <!-- Camp per demanar la descripció de la tasca -->
            <div class="mb-3">
                <label for="lastname">Escriu els cognoms de l'usuari: </label>
                <input id="lastname" type="text" v-model="input.lastname" />
            </div>
            <!-- Camp per demanar la prioritat de la tasca -->
            <div class="mb-3">
                <label for="email">Escriu la contrasenya de l'usuari: </label>
                <input id="email" type="text" v-model="input.email" />
            </div>
            <!-- Botó per fer la creació d'usuari -->
            <button class="btn btn-outline-dark" type="submit">Crear usuari</button>
        </form>
    </div>
</template>

<script>
</script>

<style>
</style>