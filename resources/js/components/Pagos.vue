<template>
    <v-card>
        <v-data-table
            :headers="headers"
            :items="pagos"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title><strong>Pagos</strong></v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <!-- Descargar Excel <CreateUsers v-on:updTable="updateTable($event)"></CreateUsers> -->
                </v-toolbar>
            </template>
            <template>
                <ShowPagos>
                <!--  Ver detalles de pagos -->
                </ShowPagos>
            </template>
            <template v-slot:item.name="{ item }">
                {{ item.client.name }}
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
    export default {
        name: 'Pagos',
        components: {
            
        },
        mounted: function(){    //ciclo de vida del componente
            this.getPagos()
        },
        data: () => {
            return {
                headers:[
                    { text: 'ID', value: 'id' },
                    { text: 'Nombre', value: 'name' },
                    { text: 'Monto del Prestamo', value: 'cantidad' },
                    { text: 'Cuota', value: 'cuota' },
                    { text: 'No. Pagos', value: 'noPagos'},
                    { text: 'Pagos realizados', value: 'pagos_realizados'},
                    { text: 'Saldo Abonado', value: 'prestamo_abonado'},
                    { text: 'Saldo Pendiente', value: 'prestamo_restante'},
                    { text: 'Acciones', value: 'actions'},
                ],
                pagos: [],
                //eliminado: false
            }  
        },
        methods: {
            getPagos(){                                   //Se declara una funcion en JS
                axios.get('api/pagos')
                    .then(response=>(                       //axios: UNa libreri de js para hacer peticiones
                    this.pagos = response.data           //Guarda la respuesta en el arreglo
                ))
                .catch(error=>{
                    console.log(error)
                })
            },
            updateTable(dataUpd){
                if(dataUpd==true)
                {
                    this.getPagos()
                }
            }
        },
    }
</script>