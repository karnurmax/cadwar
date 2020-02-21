<template>
    <div class="container-fluid">
        <div class="row">
            <div class="page-title col-12">
                <p>
                    <h2>Рабочие
                        <b-button @click="addItem()" variant="primary">
                            <font-awesome-icon icon="plus" /> Добавить
                        </b-button>
                        
                        <b-button v-b-toggle.filtersdiv variant="secondary">
                            <font-awesome-icon icon="filter" />Фильтры
                        </b-button>
                    </h2>
                </p>
            </div>
            
            <b-collapse id="filtersdiv" class="mt-2">
                <b-card>
                    <b-form-group label="Должность">
                        <b-form-checkbox-group
                            v-model="filters.selectedPositions"
                            :options="positionDict"
                            name="position-filters"
                            stacked
                        ></b-form-checkbox-group>
                    </b-form-group>
                    <b-form-group label="Национальность">
                        <b-form-checkbox-group
                            v-model="filters.selectedCitizenships"
                            :options="citizenshipDict"
                            name="citizenship-filters"
                            stacked
                        ></b-form-checkbox-group>
                    </b-form-group>
                    <b-form-group label="Статус">
                        <b-form-checkbox-group
                            v-model="filters.selectedStatuses"
                            :options="statusDict"
                            name="status-filters"
                            stacked
                        ></b-form-checkbox-group>
                    </b-form-group>
                </b-card>
            </b-collapse>
            <div class="div1 col-12">
                <b-table :fields="fields" :items="list" :striped="true" :bordered="true"
                :sort-by.sync="sortBy"
                >
                    <template v-slot:cell(index)="data">
                        {{ data.index + 1 }}
                    </template>
                    
                    <template v-slot:cell(fio)="data">
                        <b>{{ data.item.surname }} {{(data.item.name && data.item.name[0])}} {{(data.item.lastname && data.item.lastname[0])}}</b>
                    </template>

                    <template v-slot:cell(iin)="data">
                        <b>{{ data.item.iin }}</b>
                    </template>
                    
                    <template v-slot:cell(position)="data">
                        <b>{{ data.item.position }}</b>
                    </template>

                    <template v-slot:cell(citizenship)="data">
                        <b>{{ data.item.citizenship }}</b>
                    </template>

                    <template v-slot:cell(status)="data">
                        <b>{{getStatusName(data.item.employee_status_id)}}</b>
                    </template>

                    <template v-slot:cell(dateOfEmployment)="data">
                        <b>{{ getDates(data.item.dateOfEmployment) }}</b>
                    </template>

                    <template v-slot:cell(dateOfDismissal)="data">
                        <b>{{ getDates(data.item.dateOfDismissal) }}</b>
                    </template>

                    <template v-slot:cell(reasonForDismissal)="data">
                        <b>{{ data.item.reasonForDismissal }}</b>
                    </template>

                    <template v-slot:cell(comments)="data">
                        <b>{{ data.item.comments }}</b>
                    </template>

                    <template v-slot:cell(files)="data">
                        <b-link @click="viewFiles(data.item)" v-if="data.item.files && data.item.files.length">
                            <b>Файлы: {{data.item.files.length}} </b>
                        </b-link>
                        <b v-else>Файлов нет</b>
                    </template>
                    
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
        </div>
        <Loading :active.sync="isLoading" :is-full-page="true"></Loading>
        <AddModal @created="newItemCreated" :dbList="dbList"
        :statusList="employeeStatuses"
        ></AddModal>
        <EditModal @updated="itemUpdated" :item="getSelectedItem" :dbList="dbList"
        :statusList="employeeStatuses"
        ></EditModal>
        <RemoveModal @removed="itemRemoved" :item="getSelectedItem" :dbList="dbList"
        :statusList="employeeStatuses"></RemoveModal>
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
                 { key: 'position', label: 'Должность'},
                 { key: 'citizenship', label: 'Гражданство'},
                 { key: 'status', label: 'Статус'},
                 { key: 'dateOfEmployment', label: 'Дата приема'},
                 { key: 'dateOfDismissal', label: 'Дата увольнения'},
                 { key: 'reasonForDismissal', label: 'Причина увольнения'},
                 { key: 'comments', label: 'Комментарии'},
                 { key:'files',label:'Файлы'},
                 { key: 'actions', label: 'Действия'},
            ],
            isLoading:false,
            list:[],
            selectedItem:null,
            dbList:[],
            emp_files:[],
            employeeStatuses:[],

            showFilters:false,
            positionDict:[],
            citizenshipDict:[],
            statusDict:[],
            filters:{
                selectedPositions:[],
                selectedCitizenships:[],
                selectedStatuses:[],
            }
        };
    },
    created(){
        crudService.getAll('employee_statuses').then(res=>{
            this.employeeStatuses = res.data;
            crudService.getAll('bases').then(resDB=>{
                this.dbList=resDB.data;
                this.loadData()
                    .then(resList=>this.fillData(resList.data));
            }); 
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
            if(!item)
            return;
            if(item.files&&item.files.length){
                item.files = item.files.map(f=>JSON.parse(f));
            }
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
        getPositionName(id){
            const db = this.positions.find(b=>b.id===id)
            return db ? db.name : '';
        },
        getCitizenshipName(id){
            const db = this.citizenships.find(b=>b.id===id)
            return db ? db.name : '';
        },
        getStatusName(id){
            const db = this.employeeStatuses.find(b=>b.id===id);
            return db ? db.name : '';
        },
        viewFiles(item){
            this.selectedItem = item;
            this.$bvModal.show('employeeFilesShowModal');
        },
        getEmpFiles(emp_id){
            return this.emp_files.filter(ef=>ef.employee_id===emp_id);
        },
        getDates(dt){
            if(!dt)
                return '';
            dt = new Date(dt);
            return !isNaN( dt.getTime()) ? dt.toLocaleDateString() : '';
        }
    },
    computed: {
        getSelectedItem(){
            const obj = {};
            Object.assign(obj,this.selectedItem);
            obj.dateOfEmployment && (obj.dateOfEmployment = obj.dateOfEmployment.substring(0,10));
            obj.dateOfDismissal && (obj.dateOfDismissal = obj.dateOfDismissal.substring(0,10));
            return obj;
        }
    },
};
</script>
<style>
    .div1{
        overflow-x:scroll;
    }
</style>