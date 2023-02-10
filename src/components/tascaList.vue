<template>
    <h1>Llista de tasques</h1>
    <tascaItem
        v-for="tasca in tasques"
        :key="tasca.id"
        :id="tasca.tascaID"
        :usuari="tasca.usuariId"
        :nom="tasca.nom"
        :descripcio="tasca.descripcio"
        :data_alta="tasca.data_alta"
        :data_inici="tasca.data_inici"
        :data_fi="tasca.data_fi"
        :prioritat="tasca.prioritat"
        :estat="tasca.estat"
        :comentari="tasca.comentari"
    ></tascaItem>
</template>

<script>
// Importem l'axios per facilitar les peticions AJAX
import axios from 'axios'

export default {
    // Nom del component
    name: 'tascaList',
    // Llista de components que utilitzarem
    components: {

    },
    // Model de dades
    data() {
        return {
            // Array que guardarà les tasques que arribin de la BdD, inicialment buit
            tasques: []
        }
    },
    // Definim els mètodes que han de tenir accés al model
    methods: {
        // Mètode que obtindrà la llista de tasques fent una petició AJAX
        llistaTasques() {
            // Petició pel mètode GET
            axios.get("")
                .then(res => this.tasques = res.data)
        }
    },
    // Aquest codi s'executa just abans de mostrar el contingut
    created() {
        this.llistaTasques()
    }
}
</script>

<style>
</style>