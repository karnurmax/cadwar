<template>
    <b-modal
        id="historiesAddModal"
        title="Добавление новой истории"
        @ok="saveItem"
    >
        <b-form @submit="onSubmit">
            <b-form-group
                id="input-group-1"
                label="База данных:"
                label-for="input-1"
            >
                <b-form-select v-model="item.base_id" id="input-1">
                    <option v-for="db in dbList" :value="db.id">{{
                        db.name
                    }}</option>
                </b-form-select>
            </b-form-group>
            <b-form-group
                id="input-group-2"
                label="ФИО работника:"
                label-for="input-2"
            >
                <b-form-select v-model="item.employer_id" id="input-2">
                    <option v-for="emp in empList" :value="emp.id">{{
                        `${emp.surname} ${emp.name} ${emp.lastname}`
                    }}</option>
                </b-form-select>
            </b-form-group>

            <b-form-group
                id="input-group-3"
                label="Где работал :"
                label-for="input-3"
            >
                <b-form-input
                    id="input-3"
                    v-model="item.workplace"
                    type="text"
                    required
                ></b-form-input>
            </b-form-group>
            <b-form-group id="input-group-4" label="От :" label-for="input-4">
                <b-form-input
                    id="input-4"
                    v-model="item.from"
                    type="date"
                ></b-form-input>
            </b-form-group>
            <b-form-group id="input-group-5" label="До :" label-for="input-5">
                <b-form-input
                    id="input-5"
                    v-model="item.to"
                    type="date"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-6" label="Инфо :" label-for="input-6">
                <b-form-input
                    id="input-6"
                    v-model="item.description"
                    type="text"
                ></b-form-input>
            </b-form-group>

            <template v-slot:modal-footer>
                <b-button type="button">Отмена</b-button>
                <b-button type="submit" variant="primary">Сохранить</b-button>
            </template>
        </b-form>
    </b-modal>
</template>

<script>
import crudService from "../../../services/crud";
export default {
    props: ["dbList", "empList"],
    data() {
        return {
            item: {},
            selectedDb: null,
            selectedEmp: null
        };
    },
    methods: {
        onSubmit() {},
        saveItem(e) {
            e.preventDefault();
            crudService.postNewItem("histories", this.item).then(res => {
                if (res.status === 200) {
                    this.$emit("created", res.data);
                    this.$bvModal.hide("historiesAddModal");
                } else {
                    window.alert("Ошибка");
                }
            });
        }
    }
};
</script>
