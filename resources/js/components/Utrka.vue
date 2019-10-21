<template>
        <div class="container">
            <div class="row justify-content-center">
                    <div class="col-md-8">
                        <select class="browser-default custom-select" v-model="raceId">
                                <option value="null" selected>Open this select menu</option>
                                <option value="2074">Navijači</option>
                                <option value="2850">Dječja utrka 2019</option>
                                <option value="2075">Dječja utrka 2018</option>
                                <option value="2795">polumaraton</option>
                                <option value="2824">5K - utrka građana</option>
                                <option value="2794">Utrka zidinama</option>
                        </select>

                        <input class="form-control" id="racerNumber" v-model="racerId"></input>
                        <button type="button" class="btn btn-primary" @click="getRaces()">Daj mi šta daš</button>
                    </div>
                <br>
                    <div class="col-md-8" v-if="race.length">
                            <table class="table">
                                    <thead class="thead-dark">
                                      <tr>
                                        <th scope="col">Ime</th>
                                        <th scope="col">Prezime</th>
                                        <th scope="col">Spol</th>
                                        <th scope="col">Startni broj</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Grad</th>
                                        <th scope="col">Klub</th>
                                        <th scope="col">Rank</th>
                                        <th scope="col">Vrijeme</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>{{ race[0].fn }}</td>
                                        <td>{{ race[0].ln }}</td>
                                        <td>{{ race[0].sx }}</td>
                                        <td>{{ race[0].sn }}</td>
                                        <td>{{ race[0].st }}</td>
                                        <td>{{ race[0].cty }}</td>
                                        <td>{{ race[0].cl }}</td>
                                        <td>{{ race[0].rnks }}</td>
                                        <td>{{ race[0].tmd }}</td>
                                      </tr>                           
                                    </tbody>
                                  </table>
                    </div>
            </div>
        </div>
</template>

<script>
    export default {
        mounted() {
            console.log("Component mounted.");
        },
        data() {
            return {
                proxyurl: "https://cors-anywhere.herokuapp.com/",
                raceId: null,
                racerId: null,
                race: []
            }
        },

        methods:{
            getRaces(){
                axios
                    .get(this.proxyurl + "https://stotinka.hr/public_api/get_race_results_by_bib/" + this.raceId + "/" + this.racerId,{
                        headers: {
                            'Access-Control-Allow-Origin': true,
                        }
                    })
                    .then(response => {
                        this.race = response.data;
                    })
                    .catch(error => {
                        this.error = true;
                    });
            }
        }
    }
</script>