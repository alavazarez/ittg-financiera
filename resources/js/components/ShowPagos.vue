<template>
    <v-card>
        <v-data-table
            :headers="headers"
            :items="showPagos"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title><strong>Detalles de pagos</strong></v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-col cols="2" sm="2" md="2">
                        <v-text-field
                        v-model="pay.abonar"
                        type="number"
                        label="Cantidad"
                        required
                        solo
                        dense
                        ></v-text-field>
                    </v-col>
                    <v-btn 
                    color="success"
                    class="mr-4"
                    @click="abono"
                    >Abonar</v-btn>
                </v-toolbar>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
    export default {
        name: 'ShowPagos',
        mounted()
        {  
            this.getShowPagos()
        },
        data:()=>{
            return{
                headers:[
                    { text: 'Numero de pago', value: 'number' },
                    { text: 'Cuota', value: 'cantidad' },
                    { text: 'Cantidad abonada', value: 'abono' },
                    { text: 'fecha de pago', value: 'fechaPago'},
                    { text: 'Fecha de abono', value: 'fechaAbono'},
                ],
                showPagos:[],
                pay:{
                    abonar:0
                }
              }  
        },
        methods:{
            getShowPagos(){  
                let id = this.$route.params.id                                 //Se declara una funcion en JS
                axios.get('/api/pagos/show/'+id)
                    .then(response=>{                      //axios: UNa libreri de js para hacer peticiones
                    this.showPagos = response.data           //Guarda la respuesta en el arreglo
                    })
                .catch(error=>{
                    console.log(error)
                })
            },
            abono(){
                let id = this.$route.params.id      
                axios.put('/api/pagos/abono/'+id, this.pay)
                .then(response=>{
                    this.getShowPagos()
                    alert("Cantidad abonada")
                    this.pay.abonar=0
                })
                .catch(error=>{
                    alert("ERROR")
                })
            }
        }
    }
</script>