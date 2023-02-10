<template>
    <div class="tasca">
        <div class="tascaID">{{ tascaID }}</div>
        <div class="usuariID">{{ usuariID }}</div>
        <div class="nomTasca">{{ nom }}</div>
        <div class="descTasca">{{ descripcio }}</div>
        <div class="dataAltTasca">{{ data_alta }}</div>
        <div class="dataIniTasca">{{ data_inici }}</div>
        <div class="dataFiTasca">{{ data_fi }}</div>
        <div class="prioritatTasca">{{ prioritat }}</div>
        <div class="estatTasca">{{ estat }}</div>
        <div class="comentariTasca">{{ comentari }}</div>
    </div>
</template>

<script>
export default {
    // Nom del component
    name: 'tascaItem',
    // Nom de les propietats que podrà rebre aquest component
    props: ["tascaID", "usuariID", "nom", "descripcio", "data_alta", "data_inici", "data_fi", "prioritat", "estat", "comentari"],
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