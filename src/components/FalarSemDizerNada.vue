<template>
    <v-container>
        <v-row class="text-center">
            <v-col cols="12">
                <v-banner>Falar Sem Dizer Nada</v-banner>
            </v-col>
        </v-row>

        <v-form
            v-model="valid"
            @submit="valid && generateGibberish"
            @submit.prevent="generateGibberish"
        >
            <v-row justify="center" align="center">
                <v-col cols="auto">
                    <v-text-field
                        v-model="start"
                        :rules="[rules.start]"
                        label="Começo"
                        maxlength="500"
                        required
                    ></v-text-field>
                </v-col>
                <v-col cols="5" sm="3" md="2" lg="2" xl="1">
                    <v-text-field
                        v-model="time"
                        type="number"
                        suffix="segundos"
                        :rules="[rules.time]"
                        label="Tempo"
                        maxlength="6"
                        required
                    ></v-text-field>
                </v-col>
                <v-col cols="auto">
                    <v-btn :disabled="!valid" type="submit">FALAR</v-btn>
                </v-col>
            </v-row>
        </v-form>

        <v-row justify="center" align="center">
            <v-col cols="12">
                <v-textarea
                    v-model="gibberish"
                    append-icon="mdi-content-copy"
                    @click:append="copyGibberish"
                    auto-grow
                    counter
                    readonly
                ></v-textarea>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
const axios = require("axios");
export default {
    name: "FalarSemDizerNada",
    data() {
        return {
            gibberish: null,
            valid: true,
            time: 5,
            start: "Caros colegas, ",
            rules: {
                start: (value) => /^[().\-?!:,a-zA-Z0-9 ]{2,500}$/.test(value),
                time: (value) => value >= 5 && value <= 600000,
            },
        };
    },
    methods: {
        generateGibberish() {
            axios
                .get("./api/GibberishAPI.php", {
                    params: {
                        start: this.start,
                        time: this.time,
                    },
                })
                .then((response) => (this.gibberish = response.data));
        },
        copyGibberish() {
            navigator.clipboard.writeText(this.gibberish);
        },
    },
    mounted() {
        this.generateGibberish();
    },
};
</script>
