<template>
    <b-modal
        id="employeeFilesModal"
        title="Просмотр файлов работника: Toktamys A"
    >
            <template>
                <b-form-file multiple :file-name-formatter="formatNames"></b-form-file>
            </template>
            <b-list-group>
                <b-list-group-item class="d-flex justify-content-between align-items-center">
                    Resume
                    <div>
                        <b-link>
                            <font-awesome-icon icon="download" />
                        </b-link>
                    </div>
                </b-list-group-item>
            </b-list-group>
    </b-modal>
</template>

<script>
import crudService from "../../../services/crud";
export default {
    props: ["dbList"],
    data() {
        return {
            item: {}
        };
    },
    methods: {
        onSubmit() {},
        saveItem(e) {
            e.preventDefault();
            crudService.postNewItem("employees", this.item).then(res => {
                if (res.status === 200) {
                    this.$emit("created", res.data);
                    this.$bvModal.hide("employeeFilesModal");
                } else {
                    window.alert("Ошибка");
                }
            });
        },
        onDbChange(dbItemId) {
            this.item.base_id = dbItemId;
        }
    }
};
</script>
