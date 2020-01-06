<template>
    <b-modal
        id="historiesEditModal"
        title="Добавление новой базы"
        @ok="saveItem"
    >
        <b-form @submit="onSubmit">
            <b-form-group
                id="input-group-1"
                label="База данных:"
                label-for="input-1"
            >
                <b-form-select
                    id="input-1"
                    v-model="item.base_id"
                >
                    <option v-for="db in dbList" :value="db.id">{{
                        db.name
                    }}</option>
                </b-form-select>
            </b-form-group>
            <b-form-group
                id="input-group-2"
                label="Работник:"
                label-for="input-2"
            >
                <b-form-select
                    id="input-2"
                    v-model="item.employee_id"
                >
                    <option v-for="emp in empList" :value="emp.id">{{
                        fioOfEmployee(emp)
                    }}</option>
                </b-form-select>
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
    props: ["dbList", "item", "empList"],
    methods: {
        onSubmit() {},
        saveItem(e) {
            e.preventDefault();
            crudService.updateItem("histories", this.item).then(res => {
                if (res.status === 200) {
                    this.$emit("updated", res.data);
                    this.$bvModal.hide("historiesEditModal");
                } else {
                    window.alert("Ошибка");
                }
            });
        },
        fioOfEmployee({ name, surname, lastname }) {
            return `${surname} ${name} ${lastname}`;
        }
    }
};
</script>
