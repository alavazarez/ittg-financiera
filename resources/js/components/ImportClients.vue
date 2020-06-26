<template>  
    <v-dialog v-model="dialog" persistent max-width="500px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on">
          Importar clientes
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline"><strong>Seleccionar archivo</strong></span>
        </v-card-title>
        <v-container>
            <template>
              <div class="col-sm-10">
                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" accept=".XLSX, .CSV" class="form-control">
              </div>
            </template>
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="actualizarTable">Cerrar</v-btn>
          <v-btn color="primary" text @click="EventSubir">Subir</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>
<script>
    export default {
       name: 'ImportForm',
        data: () => ({
          file: '',
          dialog: false,
          update: false,
      }),
       methods: {
        actualizarTable(){
              this.dialog=false
              this.update = true
              this.$emit('updTable',this.update)
              
            },
         EventSubir(){
            let formData = new FormData();
            formData.append('file', this.file);
            axios.
            post( '/api/importClients',
                    formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function(){
                   alert("Clientes Importados")
                })
                .catch(function(){
                    alert("No se importo ningun cliente")
                });
        },
        handleFileUpload(){
            this.file = this.$refs.file.files[0];
        }
        
       }
    }
</script>