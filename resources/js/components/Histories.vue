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
            <div class="col-12">
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
                                    :custom-label="nameWithLang" 
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
            <div class="col-12">
                
                
            </div>
            
            <b-table
                :fields="fields"
                :items="list"
                :striped="true"
                :bordered="true"
                :sort-by.sync="sortBy"
            >
                <!-- A virtual column -->
                <template v-slot:cell(index)="data">
                    {{ data.index + 1 }}
                </template>

                <!-- A custom formatted column -->
                <template v-slot:cell(fio)="data">
                    <b
                        >{{ data.item.surname }}
                        {{ data.item.name && data.item.name[0] }}
                        {{ data.item.lastname && data.item.lastname[0] }}</b
                    >
                </template>

                <template v-slot:cell(iin)="data">
                    <b>{{ data.item.iin }}</b>
                </template>
                <template v-slot:cell(base)="data">
                    <b>{{ getBaseName(data.item.base_id) }}</b>
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
        <Loading :active.sync="isLoading" :is-full-page="true"></Loading>
        <AddModal @created="newItemCreated" :dbList="dbList"></AddModal>
        <EditModal
            @updated="itemUpdated"
            :item="getSelectedItem"
            :dbList="dbList"
        ></EditModal>
        <RemoveModal
            @removed="itemRemoved"
            :item="getSelectedItem"
            :dbList="dbList"
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
                { key: "iin", label: "ИИН", sortable: true },
                { key: "base", label: "База", sortable: true },
                { key: "actions", label: "Объект" },
                { key: "actions", label: "Действия" },
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
        this.loadData().then(res => this.fillData(res.data));
        crudService.getAll("bases").then(res => {
            this.dbList = res.data;
        });
    },
    methods: {
        loadData() {
            return crudService.getAll("employees");
        },
        fillData(list) {
            this.list = list;
        },
        addItem() {
            this.$bvModal.show("employeesAddModal");
        },
        newItemCreated(item) {
            this.list.push(item);
        },
        editItem(item) {
            this.selectedItem = item;
            this.$bvModal.show("employeesEditModal");
        },
        itemUpdated(item) {
            if (!item) return;
            const old = this.list.find(i => i.id == item.id);
            Object.assign(old, item);
        },
        removeItem(item) {
            this.selectedItem = item;
            this.$bvModal.show("employeesRemoveModal");
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
        nameWithLang ({ name, language }) {
            return `${name} — [${language}]`
        },
        fioOfEmployee(){
            return 'asd';
        },
        resetFilters(){
            this.selectedDb=null;
            this.selectedEmployee=null;
        },
        applyFilters(){}
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
