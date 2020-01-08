<template>
    <div class="container">
        <div class="row">
            <div class="page-title col-12">
                <p>
                    <h3>Записи в истории
                        <b-button @click="addItem()" variant="primary">
                            <font-awesome-icon icon="plus" /> Добавить
                        </b-button>
                    </h3>
                </p>
            </div>
            <div class="col-12" style="display:none;">
                <b-button
                    :class="filtersVisible ? null : 'collapsed'"
                    :aria-expanded="filtersVisible ? 'true' : 'false'"
                    aria-controls="collapse-3"
                    @click="filtersVisible = !filtersVisible">Фильтры</b-button>
                <b-button variant="outline-secondary" @click="resetFilters">Сбросить</b-button>
                <b-button @click="applyFilters" variant="info">Применить</b-button>
                <b-collapse visible id="collapse-3" v-model="filtersVisible">
                    <table class="table">
                        <tr>
                            <td>
                                <multiselect 
                                    v-model="selectedDb" 
                                    :options="dbList" 
                                    :custom-label="getName" 
                                    placeholder="Выберите базу" 
                                    label="name" 
                                    track-by="name">
                                </multiselect>
                            </td>
                            <td>
                                <multiselect 
                                    v-model="selectedEmployee" 
                                    :options="employeesList" 
                                    :custom-label="fioOfEmployee" 
                                    placeholder="Выберите работника" 
                                    label="name" 
                                    track-by="name">
                                </multiselect>
                            </td>
                        </tr>
                    </table>
                </b-collapse>
            </div>
            
            <b-table
                :fields="fields"
                :items="list"
                :striped="true"
                :bordered="true"
                :sort-by.sync="sortBy"
            >
                <template v-slot:cell(index)="data">
                    {{ data.index + 1 }}
                </template>   
                <template v-slot:cell(fio)="data">
                    <b>{{ fioOfEmployee(getEmployeeOfHistory(data.item)) }}</b>
                </template>
                <template v-slot:cell(workplace)="data">
                    <b>{{ data.item.workplace }}</b>
                </template>
                <template v-slot:cell(dates)="data">
                    <b>{{ getDates(data.item) }}</b>
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
        <Loading :active.sync="isLoading" :is-full-page="true"></Loading>
        <AddModal @created="newItemCreated" :dbList="dbList" :empList="employeesList"></AddModal>
        <EditModal
            @updated="itemUpdated"
            :item="getSelectedItem"
            :dbList="dbList"
            :empList="employeesList"
        ></EditModal>
        <RemoveModal
            @removed="itemRemoved"
            :item="getSelectedItem"
            :dbList="dbList"
            :empList="employeesList"
        ></RemoveModal>
    </div>
</template>

<script>
import crudService from "../services/crud";
import AddModal from "./crud/histories/add";
import EditModal from "./crud/histories/edit";
import RemoveModal from "./crud/histories/remove";
import Multiselect from 'vue-multiselect'


export default {
    components: {
        AddModal,
        EditModal,
        RemoveModal,
        Multiselect
    },
    data() {
        return {
            sortBy: "name",
            fields: [
                { key: "index", label: "№" },
                { key: "fio", label: "ФИО", sortable: true },
                { key: "workplace", label: "Объект" },
                { key: "dates", label: "Даты" },
                { key: "actions", label: "Действия" }
            ],
            isLoading: false,
            filtersVisible:false,
            list: [],
            selectedItem: null,
            dbList: [],
            selectedDb: null,

            employeesList:[],
            selectedEmployee:null
        };
    },
    created() {
        
        crudService.getAll("bases").then(res => {
            this.dbList = res.data;
            crudService.getAll("employees").then(res => {
                this.employeesList = res.data;
                this.loadData().then(res => this.fillData(res.data));
            });
        })
    },
    methods: {
        loadData() {
            return crudService.getAll("histories");
        },
        fillData(list) {
            this.list = list;
        },
        addItem() {
            this.$bvModal.show("historiesAddModal");
        },
        newItemCreated(item) {
            this.list.push(item);
        },
        editItem(item) {
            this.selectedItem = item;
            this.$bvModal.show("historiesEditModal");
        },
        itemUpdated(item) {
            if (!item) return;
            const old = this.list.find(i => i.id == item.id);
            Object.assign(old, item);
        },
        removeItem(item) {
            this.selectedItem = item;
            this.$bvModal.show("historiesRemoveModal");
        },
        itemRemoved(id) {
            if (!id) return;
            const idx = this.list.findIndex(x => x.id === id);
            this.list.splice(idx, 1);
        },
        getBaseName(id) {
            const db = this.dbList.find(b => b.id === id);
            return db ? db.name : "";
        },
        getName ({ name }) {
            return name;
        },
        fioOfEmployee({name,surname,lastname}){
            return `${surname || ""} ${name || ""} ${lastname || ""}`;
        },
        resetFilters(){
            this.selectedDb=null;
            this.selectedEmployee=null;
        },
        applyFilters(){},
        getEmployeeOfHistory(history_item){
            return this.employeesList.find(e=>e.id===history_item.employee_id);
        },
        getDates(item){
            let from = item.from && new Date(item.from);
            from = !isNaN( from.getTime()) ? 'C '+ from.toLocaleDateString() : '';
            let to = item.to && new Date(item.to);
            to = !isNaN(to.getTime()) ? ' по' + to.toLocaleDateString() : '';
            return from + to;
        }
    },
    computed: {
        getSelectedItem() {
            const obj = {};
            Object.assign(obj, this.selectedItem);
            return obj;
        }
    }
};
</script>
