<template>
    <div class="container">
        <div class="row">
            <div class="page-title">
                <p>
                    <h2>Рабочие
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
                <template v-slot:cell(fio)="data">
                     <b>{{ data.item.surname }} {{(data.item.name && data.item.name[0])}} {{(data.item.lastname && data.item.lastname[0])}}</b>
                </template>

                <template v-slot:cell(iin)="data">
                     <b>{{ data.item.iin }}</b>
                </template>
                <template v-slot:cell(base)="data">
                     <b>{{ getBaseName(data.item.base_id) }}</b>
                </template>
                 <template v-slot:cell(files)="data">
                    <b-link @click="viewFiles(data.item)" v-if="data.item.files && data.item.files.length">
                        <b>Файлы: {{data.item.files.length}} </b>
                    </b-link>
                    <b v-else>Файлов нет</b>
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
        <AddModal @created="newItemCreated" :dbList="dbList"></AddModal>
        <EditModal @updated="itemUpdated" :item="getSelectedItem" :dbList="dbList"></EditModal>
        <RemoveModal @removed="itemRemoved" :item="getSelectedItem" :dbList="dbList"></RemoveModal>
        <ViewFilesModal :employee="selectedItem"></ViewFilesModal>

    </div>
</template>

<script>
import crudService from '../services/crud';
import empService from '../services/employee';
import AddModal from './crud/employees/add';
import EditModal from './crud/employees/edit';
import RemoveModal from './crud/employees/remove';
import ViewFilesModal from './crud/employees/viewfiles';


export default {
    components:{
        AddModal,
        EditModal,
        RemoveModal,
        ViewFilesModal
    },
    data() {
        return {
            sortBy: 'name',
            fields:[
                 { key: 'index', label: '№' },
                 { key: 'fio', label: 'ФИО',sortable: true },
                 { key: 'iin', label: 'ИИН',sortable: true },
                 {key:'base',label:'База',sortable:true},
                 {key:'files',label:'Файлы'},
                 { key: 'actions', label: 'Действия'},
            ],
            isLoading:false,
            list:[],
            selectedItem:null,
            dbList:[],
            emp_files:[]
        };
    },
    created(){
        crudService.getAll('bases').then(res=>{
            this.dbList=res.data;
            this.loadData()
                .then(res=>this.fillData(res.data));
        }); 
    },
    methods:{
        loadData(){
            return empService.getAllWithFiles();
        },
        fillData(list){
            this.list = list;
        },
        addItem(){
            this.$bvModal.show('employeesAddModal');
        },
        newItemCreated(item){
            this.list.push(item);
        },
        editItem(item){
            this.selectedItem = item;
            this.$bvModal.show('employeesEditModal');
        },
        itemUpdated(item){
            if(!item)
                return;
            const old = this.list.find(i=>i.id==item.id);
            Object.assign(old, item);
        },
        removeItem(item){
            this.selectedItem = item;
            this.$bvModal.show('employeesRemoveModal');
        },
        itemRemoved(id){
            if(!id)
                return;
            const idx = this.list.findIndex(x=>x.id===id);
            this.list.splice(idx,1);
        },
        getBaseName(id){
            const db = this.dbList.find(b=>b.id===id)
            return db ? db.name : '';
        },
        viewFiles(item){
            this.selectedItem = item;
            this.$bvModal.show('employeeFilesShowModal');
        },
        getEmpFiles(emp_id){
            return this.emp_files.filter(ef=>ef.employee_id===emp_id);
        }
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
