<template>
    <v-card>
        <v-data-table
            :headers="headers"
            :items="clientes"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title><strong>Clientes</strong></v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <ImportClients v-on:updTable="updateTable($event)"></ImportClients>
                    <v-spacer></v-spacer>
                    <CreateUsers v-on:updTable="updateTable($event)"></CreateUsers>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn color="green" x-small dark
                @click="editItem(item)">                       
                    Editar  
                </v-btn> 
                <v-btn color="red" x-small dark
                @click="deleteClient(item)">   
                    Borrar  
                </v-btn>    
            </template>
        </v-data-table>
        <EditClient 
        v-model="editedItem"
        :open="modal"
        @modal="modal = $event"
        v-on:updTable="updateTable($event)"
        >
        </EditClient>
    </v-card>
</template>

<script>
    import CreateUsers from '@/js/components/CreateUsers';
    import EditClient from '@/js/components/EditClient';
    import ImportClients from '@/js/components/ImportClients';
    export default {
        name: 'Clients',
        components: {
            CreateUsers,
            EditClient,
            ImportClients,
        },
        mounted: function(){    //ciclo de vida del componente
            this.getClients()
        },
        data: () => {
            return {
                headers:[
                    { text: '#', value: 'id' },
                    { text: 'Nombre', value: 'name' },
                    { text: 'Telefono', value: 'phone' },
                    { text: 'Direccion', value: 'address' },
                    { text: 'Acciones', value: 'actions'},
                ],
                clientes: [],
                eliminado: false,
                modal: false,
                editedItem: {
                    name: '',
                    phone: '',
                    address: '',
                }
            }  
        },
        methods: {
            getClients(){                                   //Se declara una funcion en JS
                axios.get('api/clients')
                    .then(response=>(                       //axios: UNa libreri de js para hacer peticiones
                    this.clientes = response.data           //Guarda la respuesta en el arreglo
                ))
                .catch(error=>{
                    console.log(error)
                })
            },
            updateTable(dataUpd){
                if(dataUpd==true)
                {
                    this.getClients()
                }
            },
            deleteClient(item)
            {
                const index = this.clientes.indexOf(item)
                const id = this.clientes[index].id;
                axios.post('api/clients/'+id)
                    .then(response=>{                       //axios: UNa libreri de js para hacer peticiones
                        this.eliminado=true
                        this.updateTable(this.eliminado)
                        alert('Borrado')           //Guarda la respuesta en el arreglo
                    })
                .catch(error=>{
                    console.log(error)
                })
            },
            editItem(item) 
            {
                this.editedItem = Object.assign({}, item)
                this.modal = true
                
            },
        },
    }
</script>