<template>
    <div>
   <!-- Modal -->
   <modal name="editCard" class="model">
      <div class="modelContent">
        <div class="model-header">
            <h3>Edit Card</h3>
            <button class="closeModel" @click="hide">X</button>
        </div>
        <p class="label">Title:</p>
        <input type="text" v-model="cardDetail.cardTitle" class="input">
        <p class="label">Description:</p>
        <textarea rows="5" cols="50" v-model="cardDetail.cardDescription" class="textarea"></textarea>
        <br>
        <button @click="updateCard" class="addBtn">Update</button>
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
        props: ['cardData','columnDate'],
         data() {
            return {
                
                cardDetail: this.cardData,
                tasksCompletedNew: this.columnDate
            }
        },
        mounted() {
         
        },
        methods:{

            hide(){
                this.$modal.hide('editCard');
            },
             updateCard(){

              const card = this.tasksCompletedNew[this.cardData.colIndex].cards.filter((obj) => {
                      return this.cardData.cardId === obj.id;
              }).pop();

              card.title = this.cardData.cardTitle;
              card.description = this.cardData.cardDescription;
               this.$modal.hide('editCard');
              axios.patch('http://192.241.139.188/demos/demotask/public/demos/card/' + this.cardData.cardId, {
                  title: this.cardData.cardTitle,
                  description: this.cardData.cardDescription,
              }).then((response) => {
                  console.log(response.data);
              }).catch((error) => {
                  console.log(error);
              })
            }
        }

      }


  </script>