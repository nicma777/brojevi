<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" v-if="!readyForMath()">
                    <div class="card-header text-center">
                        <i class="fa fa-glass icons"></i>  Pick your numbers! <i class="fa fa-glass icons"></i>
                    </div>

                    <div class="col-md-offset-1 mx-auto top-bot" v-if="smallNumbers.length < 4">
                        <div class="btn-group" role="group1" >
                            <button type="button" class="btn btn-primary split" @click="addSmallNumber(id,1)" :class="{disabled: chosenNumbers.includes(1)}">1</button>
                            <button type="button" class="btn btn-primary split" @click="addSmallNumber(id,2)" :class="{disabled: chosenNumbers.includes(2)}">2</button>
                            <button type="button" class="btn btn-primary split" @click="addSmallNumber(id,3)" :class="{disabled: chosenNumbers.includes(3)}">3</button>
                            <button type="button" class="btn btn-primary split" @click="addSmallNumber(id,4)" :class="{disabled: chosenNumbers.includes(4)}">4</button>
                            <button type="button" class="btn btn-primary split" @click="addSmallNumber(id,5)" :class="{disabled: chosenNumbers.includes(5)}">5</button>
                            <button type="button" class="btn btn-primary split" @click="addSmallNumber(id,6)" :class="{disabled: chosenNumbers.includes(6)}">6</button>
                            <button type="button" class="btn btn-primary split" @click="addSmallNumber(id,7)" :class="{disabled: chosenNumbers.includes(7)}">7</button>
                            <button type="button" class="btn btn-primary split" @click="addSmallNumber(id,8)" :class="{disabled: chosenNumbers.includes(8)}">8</button>
                            <button type="button" class="btn btn-primary split" @click="addSmallNumber(id,9)" :class="{disabled: chosenNumbers.includes(9)}">9</button>
                            <button type="button" class="btn btn-primary split" @click="addSmallNumber(id,10)" :class="{disabled: chosenNumbers.includes(10)}">10</button>
                          </div>
                        </div>
                        

                    <div class="btn-group top-bot" role="group2" v-if="bigNumbers.length < 2">
                        <button type="button" class="btn btn-primary split" @click="addBigNumber(id,25)" :class="{disabled: chosenNumbers.includes(25)}">25</button>
                        <button type="button" class="btn btn-primary split" @click="addBigNumber(id,50)" :class="{disabled: chosenNumbers.includes(50)}">50</button>
                        <button type="button" class="btn btn-primary split" @click="addBigNumber(id,75)" :class="{disabled: chosenNumbers.includes(75)}">75</button>
                        <button type="button" class="btn btn-primary split" @click="addBigNumber(id,100)" :class="{disabled: chosenNumbers.includes(100)}">100</button>
                    </div>
                    <div class="col-md-4 mx-auto text-center input-group">
                        <input type="text" id="codeInput" class="form-control" placeholder="Enter the code" v-model="recivedCode">
                        <button type="button" class="btn btn-danger split" @click="challengeAccepted(recivedCode)">GO</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center" v-if="readyForMath()">
            <div class="col-md-8">
                <div class="card" >
                        <div class="card-header text-center">
                                <i class="fa fa-glass icons"></i>  Do some math! <i class="fa fa-glass icons"></i>
                        </div>

                        <div class="col-md-offset-1 mx-auto top-bot">
                            <button v-for="number in smallNumbers" type="button" @click="addUsedNumbers(number)" class="btn btn-primary split" v-text="number[1]" :class="{disabled: usedNumbersId.includes(number[0])}"></button>
                            <button v-for="number in bigNumbers" type="button" @click="addUsedNumbers(number)" class="btn btn-primary split" v-text="number[1]" :class="{disabled: usedNumbersId.includes(number[0])}"></button>
                            <button type="button" class="btn btn-danger split" @click="challenge()" v-text="duelText"></button> 
                        </div>

                        <div class="col-md-offset-1 mx-auto" v-if="newNumbers.length">        
                            <button v-for="number in newNumbers" type="button" @click="addUsedNumbers(number)" class="btn btn-primary split" v-text="number[1]" :class="[{disabled: usedNumbersId.includes(number[0])},isEqual(number[1])]"></button>                      
                        </div>    


                        <div class="form-group purple-border mx-auto calculator">
                            <label for="numberInput" class="badge badge-pill badge-primary lb-md">Calculator:</label> 
                            <p class="badge badge-pill badge-success lb-md" v-text="random"></p>
                            <button type="button" class="btn btn-primary split operators" @click="addOperator('+')">+</button>
                            <button type="button" class="btn btn-primary split operators" @click="addOperator('-')">-</button>
                            <button ty pe="button" class="btn btn-primary split operators" @click="addOperator('/')">/</button>
                            <button type="button" class="btn btn-primary split operators" @click="addOperator('*')">*</button> 

                            <button type=button class="btn btn-danger float-right bot" @click="clear()">Clear</button>
                        </div>
                        <div class="row justify-content-around">
                            <div class="col-md-5 border border-primary" v-if="logNumbers.length">
                                <p>Click to remove equation!</p>
                                <button type="button" v-for="(value,index) in logNumbers" class="btn btn-info log" v-text="value[0][1]+value[1]+value[2][1]+'='+value[3][1]"
                                @click="removeLog(index)"></button>
                            </div>

                            <div class="col-md-3">
                                <button type=button v-if="chosenCalcNum1 != null" class="btn btn-info unclickable" v-text="chosenCalcNum1[1]"></button>
                                <button type=button v-if="chosenOperator != null" class="btn btn-info unclickable operators" v-text="chosenOperator"></button>
                                <button type=button v-if="chosenCalcNum2 != null" class="btn btn-info unclickable" v-text="chosenCalcNum2[1]"></button>
                            </div>                           
                        </div>
                </div>               
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
                multiplayer: Math.floor(Math.random() * 1000 + 1), //generiramo kod koji saljemo drugom igracu
                recivedCode: null, //generirano kod kojim se povezujemo s prvim igracem
                chosenNumbers: [], // brojeve koje biramo u prvom koraku( njih 6)
                smallNumbers: [], //prva skupina koje biramo u prvom koraku (id,number)
                bigNumbers: [], //druga skupina koje biramo u prvom koraku (id,number)
                usedNumbersId: [], //id brojeva koje smo iskoristili u drugom koraku
                newNumbers: [], // brojevi koje dobijemo nekim racunskim operacijama na starim ili novim brojevima
                calcStr: "", //prvi broj - racunska operacija - drugi broj
                calcAll: [], //splitani calcStr
                calcNumber: null, // izracunati broj od calcStr
                random: Math.floor(Math.random()*(999-100+1)+100),
                id: 0,
                chosenCalcNum1: null, // prvi broj koji koristimo za racunanje
                chosenCalcNum2: null, // drugi broj koji koristimo za racunanje
                chosenOperator: null, // operator koji koristimo za racunanje
                logNumbers: [],  // popis iskoristenih racunskih operacija
                duelText: "Duel" // ime buttona ovisno dali smo nekoga izazvali ili ne
            }
        },

        methods: {
            challengeAccepted(code){
                axios.post('/getduel', { code: code})
                .then(response => {
                    this.smallNumbers = [];
                    this.bigNumbers = [];
                    this.random = response.data.number_target;
                    this.multiplayer = response.data.code;
                    this.id = 6; 
                for(let i = 0; i < 4; i++){ //punimo smallnumbers array
                    this.smallNumbers.push([i,eval('response.data.number_'+i)])
                }
                for(let i = 4; i < 6; i++){ //punimo bignumbers array
                    this.bigNumbers.push([i,eval('response.data.number_'+i)])
                }
                    
                })
                .catch(error => {
                    console.log(error);
                });
            },
            challenge(){
                let data = {
                    smallNumbers: this.smallNumbers,
                    bigNumbers: this.bigNumbers,
                    random: this.random,
                    multiplayer: this.multiplayer
                };
                this.duelText = this.multiplayer;
                axios.post('/duel', data )
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            addSmallNumber(id,number){
                this.smallNumbers.push([id,number]);
                this.chosenNumbers.push(number);
                this.id++;
            },
            addBigNumber(id,number){
                this.bigNumbers.push([id,number]);
                this.chosenNumbers.push(number);
                this.id++;
            },
            readyForMath(){
                if(this.smallNumbers.length == 4 && this.bigNumbers.length == 2){
                    return true;
                }
            },
            clear(){
                this.calcStr = "";
                this.newNumbers = [];
                this.usedNumbersId = [];
                this.calcNumber = null;
                this.id = 6;
                this.chosenCalcNum1 = null;
                this.chosenCalcNum2 = null;
                this.chosenOperator = null;
                this.logNumbers = [];
            },
            isEqual(number){
                return {
                    'btn-success':  (number == this.random && ((this.smallNumbers.length+this.bigNumbers.length+this.newNumbers.length) == (this.usedNumbersId.length+1))),
                    'btn-primary':  number != this.random
                }
            },
            addUsedNumbers(number){
                this.usedNumbersId.push(number[0]);
                this.calcStr = this.calcStr+number[1];

                if(this.chosenCalcNum1 == null){
                    this.chosenCalcNum1 = number;
                }else{
                    this.chosenCalcNum2 = number;
                    this.calculateInput();
                    this.logNumbers.push([this.chosenCalcNum1,this.chosenOperator,this.chosenCalcNum2,[this.id-1,this.calcNumber]])
                    setTimeout(this.clearChosenCalcNumbers,500)
                }
                
            },
            clearChosenCalcNumbers(){
                this.chosenCalcNum1 = null;
                this.chosenCalcNum2 = null;
                this.chosenOperator = null;
            },
            addOperator(operator){
                this.calcStr = this.calcStr+operator;
                this.chosenOperator = operator;
            },
            removeLog(index){
                Vue.delete(this.usedNumbersId, this.usedNumbersId.indexOf(this.logNumbers[index][0][0]));
                Vue.delete(this.usedNumbersId, this.usedNumbersId.indexOf(this.logNumbers[index][2][0]));
                Vue.delete(this.newNumbers, index);
                Vue.delete(this.logNumbers, index);
                if(this.checkIfExists() != null){   // provjerava dali treba izbrisati jos brojeva iz novih brojeva zbog nepostojanja neke vrijednosti
                    this.removeLog(this.checkIfExists())
                }
                
            },
            checkIfExists(){
                let checkForId = [];
                for(let i = 0; i < this.newNumbers.length; i++){ 
                    checkForId.push(this.newNumbers[i][0]);  // punimo polje Idovima novih brojeva
                }
                for(let i = 0; i < this.usedNumbersId.length; i++){
                    if(this.usedNumbersId[i] >= 6 && !checkForId.includes(this.usedNumbersId[i])){ //dali smo koristili neki broj koji nije u novim brojevima
                        for(let x = 0; x < this.logNumbers.length; x++){
                            if((this.usedNumbersId[i] == this.logNumbers[x][0][0]) || (this.usedNumbersId[i] == this.logNumbers[x][2][0])){ //trazimo index u logNumbers broja koji tu nebi trebao biti jer jedan od cimbenika ne postoji u newNumbers
                                return x;
                            }
                        }
                    }
                }
            },
            calculateInput: function(event){
                    for(let i = 0; i < this.calcStr.length; i++){
                        if(this.calcStr[i] == '+'){
                            this.calcAll = this.calcStr.split('+');
                            this.calcNumber = parseInt(this.calcAll[0])+parseInt(this.calcAll[1]);
                            this.newNumbers.push([this.id,this.calcNumber]);this.id++;
                            this.calcStr = "";
                        }
                        else if(this.calcStr[i] == '-'){
                            this.calcAll = this.calcStr.split('-');
                            this.calcNumber = parseInt(this.calcAll[0])-parseInt(this.calcAll[1]);
                            this.newNumbers.push([this.id,this.calcNumber]);this.id++;
                            this.calcStr = "";
                        }
                        else if(this.calcStr[i] == '/'){
                            this.calcAll = this.calcStr.split('/');
                            this.calcNumber = parseInt(this.calcAll[0])/parseInt(this.calcAll[1]);
                            this.newNumbers.push([this.id,this.calcNumber]);this.id++;
                            this.calcStr = "";
                        }
                        else if(this.calcStr[i] == '*'){
                            this.calcAll = this.calcStr.split('*');
                            this.calcNumber = parseInt(this.calcAll[0])*parseInt(this.calcAll[1]);
                            this.newNumbers.push([this.id,this.calcNumber]);this.id++;
                            this.calcStr = "";
                        }
                    }
                 
            }
        }
    };
</script>
