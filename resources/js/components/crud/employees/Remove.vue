<template>
    <b-modal
        id="employeesRemoveModal"
        title="Удаление работника"
        @ok="saveItem"
    >
        <b-form @submit="onSubmit">
            <b-form-group
                id="input-group-1"
                label="База данных:"
                label-for="input-1"
            >
                <b-form-select disabled id="input-1" v-model="item.base_id">
                    <option v-for="db in dbList" :value="db.id">{{
                        db.name
                    }}</option>
                </b-form-select>
            </b-form-group>

            <b-form-group id="input-group-2" label="Имя :" label-for="input-2">
                <b-form-input
                    disabled
                    id="input-2"
                    v-model="item.name"
                    type="text"
                    required
                ></b-form-input>
            </b-form-group>
            <b-form-group
                id="input-group-3"
                label="Фамилия :"
                label-for="input-3"
            >
                <b-form-input
                    disabled
                    id="input-3"
                    v-model="item.surname"
                    type="text"
                    required
                ></b-form-input>
            </b-form-group>
            <b-form-group
                id="input-group-4"
                label="Отчество :"
                label-for="input-4"
            >
                <b-form-input
                    disabled
                    id="input-4"
                    v-model="item.lastname"
                    type="text"
                    required
                ></b-form-input>
            </b-form-group>
            <b-form-group id="input-group-5" label="ИИН :" label-for="input-5">
                <b-form-input
                    disabled
                    id="input-5"
                    v-model="item.iin"
                    type="text"
                    required
                ></b-form-input>
            </b-form-group>
            <b-form-group
                id="input-group-7"
                label="Удаление прикрепленных файлов"
                label-for="input-7"
            >
                <b-list-group>
                    <b-list-group-item
                        v-for="f in item.files"
                        :key="f.lastModified"
                        class="d-flex justify-content-between align-items-center"
                    >
                        {{ f.filename }}
                    </b-list-group-item>
                </b-list-group>
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
import empService from "../../../services/employee";
export default {
    props: ["dbList", "item"],
    methods: {
        onSubmit() {},
        saveItem(e) {
            e.preventDefault();
            empService
                .removeFileListOnServer(this.item.files.map(q => q.id))
                .then(() => {
                    crudService.removeItem("employees", this.item.id).then(res => {
                        if (res.status === 200) {
                            this.$emit("removed", res.data); //id
                            this.$bvModal.hide("employeesRemoveModal");
                        } else {
                            window.alert("Ошибка");
                        }
                    });
                });
        }
    }
};
</script>
