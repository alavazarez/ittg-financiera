<template>
  <v-row justify="end">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on">
          Nuevo Prestamo
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline"><strong>Crear Prestamo</strong></span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-select
                  v-model="prestamo.client_id"
                  :items="names"
                  item-text="name"
                  item-value="id"
                  label="Nombre"
              ></v-select>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                    v-model="prestamo.cantidad"
                    label="cantidad" 
                    type="text" 
                    required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                v-model="prestamo.noPagos"
                label="noPagos" 
                type="text" 
                required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                v-model="prestamo.cuota"
                label="cuota" 
                type="text" 
                required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                v-model="prestamo.fechaMinistracion"
                label="fechaMinistracion" 
                type="date" 
                required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                v-model="prestamo.fechaVencimiento"
                label="fechaVencimiento" 
                type="date" 
                required>
                </v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" text @click="guardar">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
    export default {
       name: 'CreatePrestamos',
       mounted: function(){
         this.getNames()
       },
       data: () => ({
           dialog: false,
           prestamo:{
               client_id:'',
               cantidad:'',
               noPagos:'',
               cuota:'',
               fechaMinistracion:'',
               fechaVencimiento:''
           },
           update: false,
           names:[],
           select: { state: 'Nombre', abbr: 'id' },
       }),
       methods: {
            guardar(){
                axios.post('api/prestamos',this.prestamo)
                    .then(response=>{
                        this.updateTable()
                        this.dialog = false
                    })
                .catch(error=>(
                    console.log(error)
                ))
            },
            updateTable(){
                this.update = true
                this.$emit('updTable', this.update)
            },
            getNames(){
              axios.get('api/prestamos/names')
                .then(response=>{
                  this.names=response.data
                })
                .catch (error=>{
                  console.log(error)
                })
            }
        },
    }
</script>

