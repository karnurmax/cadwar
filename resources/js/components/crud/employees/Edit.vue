<template>
    <b-modal
        id="employeesEditModal"
        :title="'Редактировать данные ' + fioOfEmployee()"
        @ok="saveItem"
        @show="onModalShow"
    >
        <b-form @submit="onSubmit">
            
            <b-form-group id="input-group-2" label="Имя :" label-for="input-2">
                <b-form-input
                    id="input-2"
                    v-model="item.name"
                    type="text"
                    required
                    placeholder="Имя"
                ></b-form-input>
            </b-form-group>
            <b-form-group
                id="input-group-3"
                label="Фамилия :"
                label-for="input-3"
            >
                <b-form-input
                    id="input-3"
                    v-model="item.surname"
                    type="text"
                    required
                    placeholder="Фамилия"
                ></b-form-input>
            </b-form-group>
            <b-form-group
                id="input-group-4"
                label="Отчество :"
                label-for="input-4"
            >
                <b-form-input
                    id="input-4"
                    v-model="item.lastname"
                    type="text"
                    required
                    placeholder="Отчество"
                ></b-form-input>
            </b-form-group>
            <b-form-group id="input-group-5" label="ИИН :" label-for="input-5">
                <b-form-input
                    id="input-5"
                    v-model="item.iin"
                    type="text"
                    required
                    placeholder="ИИН"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-10"
                label="Должность:"
                label-for="input-10"
            >
                <b-form-input
                    id="input-10"
                    v-model="item.position"
                    type="text"
                    required
                    placeholder="Должность"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-11"
                label="Гражданство:"
                label-for="input-11"
            >
                <b-form-input
                    id="input-11"
                    v-model="item.citizenship"
                    type="text"
                    required
                    placeholder="Гражданство"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-12"
                label="Статус:"
                label-for="input-12"
            >
                <b-form-select
                    @change="onStatusChange"
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
                    type="date"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-8" label="Дата увольнения :">
                <b-form-input
                    v-model="item.dateOfDismissal"
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
                    type="text"
                    required
                    placeholder="Имя"
                ></b-form-input>
            </b-form-group>

            <hr />
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
                        <b-link style="color:red;" @click="confirmAndRemove(f)">
                            <font-awesome-icon icon="times" />
                        </b-link>
                    </b-list-group-item>
                </b-list-group>
            </b-form-group>
            <b-form-group
                id="input-group-6"
                label="Прикрепить новые файлы :"
                label-for="input-6"
            >
                <input
                    @change="onFileChange"
                    type="file"
                    ref="file"
                    style="display: none"
                    multiple
                />
                <b-button @click="$refs.file.click()">
                    <font-awesome-icon icon="plus" /> Добавить файлы
                </b-button>
                <b-list-group>
                    <b-list-group-item
                        v-for="f in files"
                        :key="f.lastModified"
                        class="d-flex justify-content-between align-items-center"
                    >
                        {{ f.name }}
                        <b-link
                            style="color:red;"
                            @click="removeSelectedFile(f.name)"
                        >
                            <font-awesome-icon icon="times" />
                        </b-link>
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
    data() {
        return {
            files: []
        };
    },
    created() {},
    methods: {
        onModalShow() {
            this.files = [];
        },
        onSubmit() {},
        saveItem(e) {
            e.preventDefault();
            const itemToPut = {};
            Object.assign(itemToPut, this.item);
            delete itemToPut.files;
            crudService.updateItem("employees", itemToPut).then(res => {
                if (res.status === 200) {
                    this.uploadFiles(this.item.id).then(resUploaded => {
                        if (resUploaded.status === 200) {
                            const arr = resUploaded.data;
                            arr.forEach(fs => {
                                this.item.files.push(JSON.parse(fs));
                            });
                            this.$emit("created", this.item);
                            this.$bvModal.hide("employeesAddModal");
                        } else window.alert("Ошибка");
                    });
                    this.$emit("updated", res.data);
                    this.$bvModal.hide("employeesEditModal");
                } else {
                    window.alert("Ошибка");
                }
            });
        },
        onDbChange(dbItemId) {
            this.item.base_id = dbItemId;
        },
        onPositionChange(id) {
            this.item.position_id = id;
        },
        onCitizenshipChange(id) {
            this.item.citizenship_id = id;
        },
        onStatusChange(id) {
            this.item.employee_status_id = id;
        },
        onFileChange(e) {
            if (!e.target.value) return;
            window.files = e.target.files;
            for (let i = 0; i < files.length; i++) {
                let f = files[i];
                if (
                    !this.files.find(
                        ef =>
                            ef.name === f.name &&
                            ef.lastModified === f.lastModified &&
                            ef.size === f.size
                    )
                )
                    this.files.push(f);
            }
        },
        removeSelectedFile(name) {
            const idx = this.files.indexOf(
                this.files.find(f => f.name === name)
            );
            this.files.splice(idx, 1);
        },
        uploadFiles(userId) {
            return empService.uploadFile(userId, this.files);
        },
        fioOfEmployee() {
            return !this.item
                ? ""
                : `${this.item.surname || ""} ${this.item.name || ""} ${this
                      .item.lastname || ""}`;
        },
        confirmAndRemove(file) {
            this.$bvModal
                .msgBoxConfirm("Удаленный файл нельзя восстановить", {
                    title: "Удалить файл ?",
                    size: "sm",
                    buttonSize: "sm",
                    okVariant: "danger",
                    okTitle: "ДА",
                    cancelTitle: "НЕТ",
                    footerClass: "p-2",
                    hideHeaderClose: false,
                    centered: true
                })
                .then(confirmed => {
                    if (confirmed) {
                        empService
                            .removeFileListOnServer(file.id)
                            .then(res => {
                                const idx = this.item.files.indexOf(file);
                                this.item.files.splice(idx, 1);
                            })
                            .catch(() => {
                                window.alert("ошибка");
                            });
                    }
                })
                .catch(() => {
                    window.alert("ошибка");
                });
        }
    }
};
</script>
