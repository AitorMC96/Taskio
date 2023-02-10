<template>
    <h1>Llista d'usuaris</h1>
</template>

<script>
// Importem l'axios per facilitar les peticions AJAX
import axios from 'axios'

export default {
    // Nom del component
    name: 'usuariList',
    // Llista de components que utilitzarem
    components: {

    },
    // Model de dades
    data() {
        return {
            // Array que guardarà els usuaris que arribin de la BdD, inicialment buit
            usuaris: []
        }
    },
    // Definim els mètodes que han de tenir accés al model
    methods: {
        // Mètode que obtindrà la llista d'usuaris fent una petició AJAX
        llistaUsuaris() {
            // Petició pel mètode GET
            axios.get("")
                .then(res => this.usuaris = res.data)
        }
    },
    // Aquest codi s'executa just abans de mostrar el contingut
    created() {
        this.llistaUsuaris()
    }
}
</script>

<style>
</style>