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
                    <v-btn @click="test">
                        Exportar
                    </v-btn>
                </v-toolbar>
            </template>
            <template>
                <ShowPagos></ShowPagos>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn dark :to="{ name:'showPagos', params:{id:item.id}}" color="yellow" x-small>                       
                    Show  
                </v-btn> 
            </template>
            <template v-slot:item.name="{ item }">
                {{ item.client.name }}
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import XLSX from "xlsx";
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
                table:[]
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
            },
            test(){                                   //Se declara una funcion en JS
                axios.get('api/pagos/table')
                    .then(response=>(                       //axios: UNa libreri de js para hacer peticiones
                    this.table = response.data           //Guarda la respuesta en el arreglo
                ))
                .catch(error=>{
                    console.log(error)
                })
            },
            exportar()
            {
                axios.get('api/pagos/table')
                    .then(response=>{
                        this.table = response.data
                    })
                /* const workbook = XLSX.utils.book_new()
                const filename = 'pagos'
                let data = XLSX.utils.json_to_sheet(this.table)
                XLSX.utils.book_append_sheet(workbook, data, filename)
                XLSX.writeFile(workbook, `${filename}.xlsx`) */
            },
        }
    }
</script>