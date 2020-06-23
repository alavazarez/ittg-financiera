<template>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="green"
          dark
          x-small
          v-bind="attrs"
          v-on="on">
          Editar
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline"><strong>Actualizar Prestamo</strong></span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-text-field 
                    v-model="prestamo.client_id"
                    label="client_id" 
                    type="text" 
                    required>
                </v-text-field>
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
                type="text" 
                required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                v-model="prestamo.fechaVencimiento"
                label="fechaVencimiento" 
                type="text" 
                required>
                </v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" text @click="guardar">Actualizar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>

<script>
    export default {
       name: 'EditPrestamo',
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
            }
        },
    }
</script>

