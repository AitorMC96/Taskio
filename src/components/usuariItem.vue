<template>
    <div class="usuari">
        <div class="usuariID">{{ usuariId }}</div>
        <div class="nomUsuari">{{ nom }}</div>
        <div class="cognomsUsuari">{{ cognoms }}</div>
        <div class="emailUsuari">{{ email }}</div>
        <div class="rolUsuari">{{ rol }}</div>
        <div class="contraUsuari">{{ contrasenya }}</div>
    </div>
</template>

<script>
export default {
    // Nom del component
    name: 'usuariItem',
    // Nom de les propietats que podrà rebre aquest component
    props: ["usuariId", "nom", "cognoms", "email", "rol", "contrasenya"],
    // Model de dades
    data() {
        return {
            minim: 5
        }
    },
    // Definim els mètodes que han de tenir accés al model
    methods: {

    }
}
</script>

<style scoped>
</style>