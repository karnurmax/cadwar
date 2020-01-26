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
                id="input-group-10"
                label="Должность:"
                label-for="input-10"
            >
                <b-form-select
                    disabled
                    id="input-10"
                    v-model="item.position_id"
                >
                    <option
                        v-for="db in positionList"
                        :value="db.id"
                        :key="db.id"
                        >{{ db.name }}</option
                    >
                </b-form-select>
            </b-form-group>

            <b-form-group
                id="input-group-11"
                label="Гражданство:"
                label-for="input-11"
            >
                <b-form-select
                    disabled
                    id="input-11"
                    v-model="item.citizenship_id"
                >
                    <option
                        v-for="db in citizenshipList"
                        :value="db.id"
                        :key="db.id"
                        >{{ db.name }}</option
                    >
                </b-form-select>
            </b-form-group>

            <b-form-group
                id="input-group-12"
                label="Статус:"
                label-for="input-12"
            >
                <b-form-select
                    disabled
                    id="input-12"
                    v-model="item.employee_status_id"
                >
                    <option
                        v-for="db in statusList"
                        :value="db.id"
                        :key="db.id"
                        >{{ db.name }}</option
                    >
                </b-form-select>
            </b-form-group>

            <b-form-group id="input-group-7" label="Дата приема:">
                <b-form-input
                    v-model="item.dateOfEmployment"
                    disabled
                    type="date"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-8" label="Дата увольнения :">
                <b-form-input
                    v-model="item.dateOfDismissal"
                    disabled
                    type="date"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-13"
                label="Причина увольнения :"
                label-for="input-13"
            >
                <b-form-input
                    id="input-13"
                    v-model="item.reasonForDismissal"
                    disabled
                    type="text"
                    required
                    placeholder="Причина увольнения"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-9"
                label="Комментарий :"
                label-for="input-9"
            >
                <b-form-input
                    id="input-9"
                    v-model="item.comments"
                    disabled
                    type="text"
                    required
                    placeholder="Имя"
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
    props: ["dbList", "item", "positionList", "citizenshipList", "statusList"],
    methods: {
        onSubmit() {},
        saveItem(e) {
            e.preventDefault();
            empService
                .removeFileListOnServer(this.item.files.map(q => q.id))
                .then(() => {
                    crudService
                        .removeItem("employees", this.item.id)
                        .then(res => {
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
