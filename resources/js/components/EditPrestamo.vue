<template>
  <v-form v-model="valid"
lazy-validation>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline"><strong>Actualizar Prestamo</strong></span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-text-field 
                    v-model="value.client_id"
                    label="client_id" 
                    type="text" 
                    required
                    readonly>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                    v-model="value.cantidad"
                    label="cantidad" 
                    type="number" 
                    :rules="cantidadRules"
                    required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                @change="sumaFecha"
                v-model="value.noPagos"
                label="noPagos" 
                type="number"
                :rules="noPagosRules" 
                required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                v-model="value.cuota"
                label="cuota" 
                type="number"
                :rules="cuotaRules" 
                required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                @change="sumaFecha"
                v-model="value.fechaMinistracion"
                label="fechaMinistracion" 
                type="date" 
                required
                readonly>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                v-model="value.fechaVencimiento"
                label="fechaVencimiento" 
                type="date" 
                required
                readonly>
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
import moment from 'moment-business-days'
    export default {
       name: 'EditPrestamo',
       mounted: function(){
         this.value.fechaMinistracion = this.fecha
         this.value.fechaVencimiento = this.fechaFinal
       },
       data: () => ({
          valid: true,
          cantidadRules:[
            v => !!v || 'Cantidad requerida'
          ],
          noPagosRules:[
            v => !!v || 'Numero de pagos requerido'
          ],
          cuotaRules:[
            v => !!v || 'Cuota requerida'
          ],
           dialog: false,
           update: false,
       }),
       computed: {
          fecha(){
            return moment().format('YYYY-MM-DD') 
          },
          fechaFinal(){
            let date = moment(this.value.fechaMinistracion).businessAdd(this.value.noPagos)._d
            date = moment(date).format('YYYY-MM-DD')
            return date
          }},
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
               client_id:'',
               cantidad:'',
               noPagos:'',
               cuota:'',
               fechaMinistracion:'',
               fechaVencimiento:''
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
                axios.post('api/prestamos/edit/'+this.value.id,this.value)
                    .then(response=>{
                        this.updateTable()
                        alert('Prestamo actualizado')
                        this.close()
                    })
                .catch(error=>{
                    console.log(error)
                    alert('Este prestamo ya cuenta con un abono')
                    this.close()
                })
            },
            updateTable(){
                this.update = true
                this.$emit('updTable', this.update)
            },
            close()
            {
                this.dialog = false
                this.$emit('modal',this.dialog)
            },
            sumaFecha()
            {
              this.value.fechaVencimiento= this.fechaFinal
            }
        },
    }
</script>

