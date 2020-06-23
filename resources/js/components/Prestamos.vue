<template>
    <v-card>
        <v-data-table
            :headers="headers"
            :items="prestamos"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title><strong>Prestamos</strong></v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <CreatePrestamo 
                        v-on:updTable="updateTable($event)">
                    </CreatePrestamo>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <EditPrestamo></EditPrestamo>
                <v-btn color="red" x-small dark
                @click="deletePrestamo(item)">   
                    Borrar  
                </v-btn>    
            </template>
            <template v-slot:item.name="{ item }">
                {{ item.client.name }}
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
    import CreatePrestamo from '@/js/components/CreatePrestamo';
    import EditPrestamo from '@/js/components/EditPrestamo';
    export default {
        name: 'Prestamos',
        components: {
            CreatePrestamo,
            EditPrestamo,
        },
        mounted: function(){    //ciclo de vida del componente
            this.getPrestamos()
        },
        data: () => {
            return {
                headers:[
                    { text: '#', value: 'id' },
                    { text: 'Nombre', value: 'name' },
                    { text: 'Cantidad prestada', value: 'cantidad' },
                    { text: '# Pagos', value: 'noPagos' },
                    { text: 'Cuota', value: 'cuota'},
                    { text: 'Total a pagar', value: 'totalPagar'},
                    { text: 'Fecha de ministracion', value: 'fechaMinistracion'},
                    { text: 'Fecha de vencimiento', value: 'fechaVencimiento'},
                    { text: 'Acciones', value: 'actions'},
                ],
                prestamos: []
                //eliminado: false
            }  
        },
        methods: {
            getPrestamos(){                                   //Se declara una funcion en JS
                axios.get('api/prestamos')
                    .then(response=>(                       //axios: UNa libreria de js para hacer peticiones
                    this.prestamos = response.data           //Guarda la respuesta en el arreglo
                ))
                .catch(error=>{
                    console.log(error)
                })
            },
            updateTable(dataUpd){
                if(dataUpd==true)
                {
                    this.getPrestamos()
                }
            },
            deletePrestamo(item)
            {
                const index = this.prestamos.indexOf(item)
                const id = this.prestamos[index].id;
                axios.post('api/prestamos/'+id)
                    .then(response=>{                       //axios: UNa libreri de js para hacer peticiones
                        this.eliminado=true
                        this.updateTable(this.eliminado)
                        alert('Borrado')           //Guarda la respuesta en el arreglo
                    })
                .catch(error=>{
                    console.log(error)
                })
            }
        },
    }
</script>