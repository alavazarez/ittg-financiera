<template>
  <v-row justify="end">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on">
          Nuevo Cliente
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline"><strong>Crear Usuario</strong></span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-text-field 
                    v-model="cliente.name"
                    label="Nombre" 
                    type="text" 
                    required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                    v-model="cliente.phone"
                    label="Telefono" 
                    type="text" 
                    required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                v-model="cliente.address"
                label="Direccion" 
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
          <v-btn color="blue darken-1" text @click="guardar">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
    export default {
       name: 'CreateUsers',
       data: () => ({
           dialog: false,
           cliente:{
               name:'',
               phone:'',
               address:''
           },
           update: false,
       }),
       methods: {
            guardar(){
                axios.post('api/clients',this.cliente)
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