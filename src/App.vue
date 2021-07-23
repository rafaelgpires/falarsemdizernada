<template>
    <v-app>
        <v-main>
            <falar-sem-dizer-nada />
        </v-main>
    </v-app>
</template>

<script>
import FalarSemDizerNada from "./components/FalarSemDizerNada.vue";

export default {
    name: "App",
    components: {
        FalarSemDizerNada,
    },
};
</script>
