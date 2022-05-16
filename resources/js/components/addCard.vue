<template>
    <div>
   <!-- Modal -->
   <modal :name="'addCard'+colId" class="model">
      <div class="modelContent">
      <div class="model-header">
          <h3>Add a card</h3>
          <button class="closeModel" @click="hide">X</button>
      </div>
      <p class="label">Title:</p>
      <input type="text" v-model="cardTitle" class="input">
      <p class="label">Description:</p>
      <textarea rows="5" cols="50" v-model="cardDescription" class="textarea"></textarea>
      <br>
      <button @click="addCard" class="addBtn">Add</button>
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
        props: ['id'],
         data() {
            return {
                colId: this.id,
                cardTitle: '',
                cardDescription: ''
            }
        },
        mounted() {
        },
        methods:{

            addCard(){

            this.$modal.hide('addCard'+this.colId);

             axios.post('http://192.241.139.188/demos/demotask/public/demos/card', {

              title: this.cardTitle,
              description: this.cardDescription,
              column_id: this.colId

                }).then((response) => {
                    console.log(response.data);
                   this.$emit('card', response.data);
                  }).catch((error) => {
                      console.log(error);
                  })

            },

            hide(){
                this.$modal.hide('addCard'+this.colId);

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
    .textarea{
      width: 100%;
      border: $border-1;
      border-radius: $border-radius-1;
    }
    .addBtn{
      background-color: rgba(34, 84, 63, 0.831372549);
      padding: 10px 30px;
      border: 1px solid rgba(34, 84, 63, 0.831372549);
      border-radius: 5px;
      color: #fff;
    }
  }
    

</style>