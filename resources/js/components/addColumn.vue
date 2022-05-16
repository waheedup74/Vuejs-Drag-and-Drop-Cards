<template>
    <div>
   <!-- Modal -->
   <modal name="addCol" class="model" resizable="true">
      <div class="modelContent">
      <div class="model-header">
          <h3>Add Coloum</h3>
          <button class="closeModel" @click="hide">X</button>
      </div>
      <p class="label">Title:</p>
      <input type="text" v-model="columnTitle" class="input">
      
      <button @click="addColumn" class="addBtn">Add</button>
      </div>
       
     </modal>
</div>
</template>
<script>
    import Vue from 'vue'
    import Vmodal from 'vue-js-modal/dist/ssr.nocss'

    import 'vue-js-modal/dist/styles.css'
    // Vue.use(Vmodal);
    export default {
        components: {
            Vmodal,
        },
        props: ['columnDate'],
         data() {
            return {
                
                columnTitle: ''
            }
        },
        mounted() {
          console.log(this.cardData);
        },
        methods:{

            addColumn(){

             axios.post('http://192.241.139.188/demos/demotask/public/demos/column', {
              title: this.columnTitle,
                  }).then((response) => {
                      console.log(response.data);
                this.$emit('column', response.data);

                  }).catch((error) => {
                      console.log(error);
                  })
                this.$modal.hide('addCol');

            },
            hide(){
                this.$modal.hide('addCol');

            }             
        }

      }


  </script>
<style lang="scss">
     @import "../../sass/_variables.scss";
    .model{
      .model-header{
        display: flex;
        justify-content: space-between;
        align-content: center;
        
        h3{
          margin-top: 5px;
          margin-bottom: 5px;
        }
        .closeModel{
          position: relative !important;
          background: $bg-tranparent;
          border: $border-0;
        }
      }
      .label{
        margin-bottom: 5px;
      }
      .input{
        width: 100%;
        padding: 10px;
        border: $border-1;
        border-radius: $border-radius-1;
      }
      .addBtn{
        background-color: rgba(34, 84, 63, 0.831372549);
        padding: 10px 30px;
        border: 1px solid rgba(34, 84, 63, 0.831372549);
        border-radius: 5px;
        color: #fff;
        margin-top: 5px;
      }
    }
</style>