<template>
  <div>
    <div class="main-heading">
    <h2>Task Demo</h2>
     <div class="" >
      
      <a href="http://192.241.139.188/demos/demotask/public/demos/db-download">Export Database</a>
     </div>
   </div>
    <div class="main_row">
        <div class="task-col" v-for="(column, keyIndex) in tasksCompletedNew" :id="column.id">

            <AddCard @card="cardData" :id="column.id" ></AddCard>

            <section class="list">
                <header>{{column.title}}  <button class="delete-col" @click="deleteCol(column.id)">X</button></header>
                <draggable class="drag-area" :list="column.cards" :options="{animation:200, group:'status'}" :element="'article'" @add="onAdd($event, column.id)"  @change="dragCard($event, keyIndex)">
                    <article class="card" v-for="(task, index) in column.cards" :key="task.id" :data-id="task.id" :data-order="task.order">
                        <header @click="show(task,keyIndex)">
                            {{ task.title }}
                        </header>
                        
                    </article>
                </draggable>  
                <button class="add-card" @click="addCard(column.id)" >+ Add a card</button> 
            </section>

            <EditCard :cardData="cardDetail" :columnDate="tasksCompletedNew"></EditCard>

            <AddColumn @column="columnData" ></AddColumn>

        </div>
        <div class="task-col">
          <button @click="addColumn" class="addCol">+ Add Column</button>
        </div>
    </div>

       </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import EditCard from './EditCard';
    import AddColumn from './addColumn';
    import AddCard from './addCard';
    import Vue from 'vue'
    import Vmodal from 'vue-js-modal/dist/ssr.nocss'

    import 'vue-js-modal/dist/styles.css'
    // Vue.use(Vmodal);
    export default {
        components: {
            draggable,
            Vmodal,
            EditCard,
            AddColumn,
            AddCard
        },
        props: ['tasksCompleted'],
        data() {
            return {
                
                tasksCompletedNew: this.tasksCompleted,
                cardDetail: {
                  cardTitle: '',
                  cardDescription: '',
                  cardId:'',
                  colIndex:''
                },
                cardTitle: '',
                cardDescription: '',
                cardId: '',
                colIndex:'',
                columnValue: {}
            }
        },
        mounted() {
          console.log('hello');
               
            },
        methods: {
          columnData(value){
            this.columnValue = value;
             this.tasksCompletedNew.push(value);
             
          },
          cardData(value){
            console.log(this.tasksCompletedNew);
            const column = this.tasksCompletedNew.filter((obj) => {
                      return value.column_id === obj.id;
              }).pop();

              column.cards.push(value);
          },
            onAdd(event, column_id) {
                let id = event.item.getAttribute('data-id');
                axios.patch('http://192.241.139.188/demos/demotask/public/demos/tasks/' + id, {
                    column_id: column_id
                }).then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                    console.log(error);
                })
            },
            dragCard(event, columnIndex) {
               
               console.log(this.tasksCompletedNew[columnIndex].cards);
             
                 this.tasksCompletedNew[columnIndex].cards.forEach(function(item, index){
                    item.order = index + 1;
                    console.log(item.order);
                  });
                // console.log(tasks);
                axios.put('http://192.241.139.188/demos/demotask/public/demos/tasks/updateAll', {
                    tasks: this.tasksCompletedNew[columnIndex].cards
                }).then((response) => {
                    console.log(response.data);
                }).catch((error) => {
                    console.log(error);
                })
            },

            addColumn(){
                this.$modal.show('addCol');
            },

            addCard(id){
              this.$modal.show('addCard'+id);
            },

            deleteCol(id){
              
              axios.delete('http://192.241.139.188/demos/demotask/public/demos/tasks/deleteColumn/'+id,{

              }).then((response) => {
                document.getElementById(id).remove();
              });
            },
            show(task,colIndex){
                this.cardDetail.colIndex = colIndex;
                // this.cardDetail = task;
                this.cardDetail.cardId = task.id;
                this.cardDetail.cardTitle = task.title;
                this.cardDetail.cardDescription = task.description;
                this.$modal.show('editCard');
            },
           

        }
    }
</script>

<style lang="scss">
     @import "../../sass/_variables.scss";

     *{
       box-sizing: border-box;
      }
     .main-heading{
       display: flex;
       justify-content: space-between;
       align-items: center;
       margin-left: 20px;
       margin-right: 13px;
     }
     .main_row{
        display: flex;
        // -ms-flex-wrap: wrap;
        // flex-wrap: wrap;
        @media (max-width: $layout-breakpoint-xsmall) {
          .task-col {
            flex: 0 0 70%;
            max-width: 100%;
          }
          .vm--modal{
            left: 0 !important;
          }
        }
     }
     .task-col{
        flex: 0 0 25%;
        max-width: 25%;
        position: relative;
        width: 100%;
        padding-left: 15px;
        padding-right: 15px;

        .addCol{
          width: 100%;
          background: #edeaea;
          border: 0;
          padding: 10px;
          margin-top: 5px;
          text-align: left;
        }
     }
    .list {
      background-color: #22543fd4;
      border-radius: 3px;
      margin: 5px 5px;
      padding: 10px;
      width: 100%;
        >header {
          font-weight: bold;
          color: $color;
          text-align: center;
          font-size: 20px;
          line-height: 28px;
          cursor: grab;
          display: flex;
          justify-content: space-between;
          margin-bottom: 10px;
          .delete-col{
            background: transparent;
            color: white;
            border: 0;
            cursor: pointer;
          }
        }
        article {
            p{
                font-weight: 400;
            }
        }
        .card {
          background-color: $color;
          border-bottom: 1px solid #CCC;
          padding: 10px 10px;
          cursor: grab;
          font-size: $font-size;
          font-weight: $font-weight;
          margin-bottom: 10px;
          border-radius: 3px;
        }
        .card:hover {
            background-color: #F0F0F0;
        }
        
    }

    .add-card{
        padding: 5px;
         /*margin-top: 10px;*/
        width:100%;
        background-color: $bg-tranparent;
        border: $border-0;
        cursor: pointer;
      }
    /*.drag-area{
     min-height: 10px;  
    }*/
    
    .model{
       border-radius: 5px;
      .modelContent{
        padding: 15px;
      }
      .closeModel{
        position: absolute;
        top: 0;
        right: 0;
      }
    }
    
</style>