<template>
    <v-card
        class="mx-auto"
        max-width="344"
        >
        <v-card-text>
            <p class="display-1 text--primary">
            Numero de clientes
            </p>
            <v-text-field
            v-model="cantidad"
            placeholder="Dense & Rounded"
            filled
            rounded
            dense
            ></v-text-field>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: 'Home',
    mounted: function(){
        this.countClients()
    },
    data:()=>({
        cantidad:0
    }),
    methods:{
        countClients()
            {axios.get('api/countClients')
                .then(response=>{
                    this.cantidad=response.data
                })
                .catch(error=>{
                    console.log(error)
                })
            }
        }
    }
</script>
            

