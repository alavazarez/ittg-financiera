<template>
<v-form v-model="valid"
lazy-validation>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline"><strong>Actualizar Usuario</strong></span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-text-field 
                    v-model="value.name"
                    label="Nombre" 
                    type="text" 
                    :rules="nameRules" 
                    required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                    v-model="value.phone"
                    label="Telefono" 
                    type="number"
                    :rules="phoneRules" 
                    required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                v-model="value.address"
                label="Direccion" 
                type="text" 
                :rules="addressRules" 
                required>
                </v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close">Close</v-btn>
          <v-btn color="blue darken-1" text @click="guardar" :disabled="!valid">Actualizar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-form>
</template>
<script>
    export default {
       name: 'EditClient',
       data: () => ({
         valid: true,
          nameRules:[
            v => !!v || 'Nombre requerido'
          ],
          phoneRules:[
            v => !!v || 'Telefono requerido'
          ],
          addressRules:[
            v => !!v || 'Direccion requerida'
          ],
           dialog: false,
           cliente:{
               name:'',
               phone:'',
               address:''
           },
           update: false,
       }),  
       props: { 
         open: {
           type:Boolean,
           default:false
         },
         value: {
           type:Object,
           default: function () {
             return {
                id:'',
                name:'',
                phone:'',
                address:''
             }
           }
         }
       },
       watch: {
         open (){
           this.dialog = this.open
         }
       },
       methods: {
            guardar(){
                axios.post('api/clients/edit/'+this.value.id,this.value)
                    .then(response=>{
                        this.updateTable()
                        this.close()
                    })
                .catch(error=>(
                    console.log(error)
                ))
            },
            updateTable(){
                this.update = true
                this.$emit('updTable', this.update)
            },
            close()
            {
                this.dialog = false
                this.$emit('modal',this.dialog)
            }
            
        },
    }
</script>