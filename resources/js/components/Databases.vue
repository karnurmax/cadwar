<template>
    <div class="container">
        <div class="row">
            <div class="page-title">
                <p>
                    <h2>Базы данных
                        <b-button @click="addItem()" variant="primary">
                                    <font-awesome-icon icon="plus" /> Добавить
                        </b-button>
                    </h2>
                </p>
            </div>
             <b-table :fields="fields" :items="list" :striped="true" :bordered="true"
             :sort-by.sync="sortBy"
             >
                <!-- A virtual column -->
                <template v-slot:cell(index)="data">
                    {{ data.index + 1 }}
                </template>

                <!-- A custom formatted column -->
                <template v-slot:cell(name)="data">
                     <b>{{ data.item.name }}</b>
                </template>

                <template v-slot:cell(created_at)="data">
                     <b>{{ data.item.created_at }}</b>
                </template>
                <!-- A virtual composite column -->
                <template v-slot:cell(actions)="data">
                    <b-button @click="editItem(data.item)">
                        <font-awesome-icon icon="pencil-alt" />
                    </b-button>
                    <b-button variant="danger" @click="removeItem(data.item)">
                        <font-awesome-icon icon="trash" />
                    </b-button>
                </template>

            </b-table>
          
        </div>
         <Loading :active.sync="isLoading" 
        :is-full-page="true"></Loading>
        <AddModal @created="newItemCreated"></AddModal>
        <EditModal @updated="itemUpdated" :item="getSelectedItem"></EditModal>
    </div>
</template>

<script>
import crudService from '../services/crud';
import AddModal from './crud/bases/add';
import EditModal from './crud/bases/edit';
export default {
    components:{
        AddModal,
        EditModal
    },
    data() {
        return {
            sortBy: 'name',
            fields:[
                 { key: 'index', label: '№' },
                 { key: 'name', label: 'Название',sortable: true },
                 { key: 'created_at', label: 'Дата создания',sortable: true },
                 { key: 'actions', label: 'Действия'},
            ],
            isLoading:false,
            list:[],
            selectedItem:null,
        };
    },
    created(){
        this.loadData()
            .then(res=>this.fillData(res.data));
    },
    methods:{
        loadData(){
            return crudService.getAll('bases');
        },
        fillData(list){
            this.list = list;
        },
        addItem(){
            this.$bvModal.show('basesAddModal');
        },
        newItemCreated(item){
            this.list.push(item);
        },
        editItem(item){
            this.selectedItem = item;
            window.console.log(this.selectedItem);
            this.$forceUpdate();
            this.$bvModal.show('basesEditModal');
        },
        itemUpdated(item){
            window.console.log(item);
        },
        removeItem(item){
            window.console.log(item);
        },
    },
    computed: {
        getSelectedItem(){
            const obj = {};
            Object.assign(obj,this.selectedItem);
            return obj;
        }        
    },
};
</script>
