<template>
    <b-modal
        id="employeeFilesShowModal"
        :title="'Просмотр файлов работника: ' + fioOfEmployee()"
    >
        <b-list-group v-if="employee != null">
            <b-list-group-item
                v-for="(f, index) in employee.files"
                v-bind:key="index"
                class="d-flex justify-content-between align-items-center"
            >
                {{ f.filename }}
                <b-button
                    type="button"
                    variant="primary"
                    @click="downloadFile(f.id)"
                >
                    <font-awesome-icon icon="download" />
                </b-button>
            </b-list-group-item>
        </b-list-group>
        <template v-slot:modal-footer>
            <b-button type="button" @click="closeModal">Закрыть</b-button>
        </template>
    </b-modal>
</template>

<script>
import crudService from "../../../services/crud";
import empService from "../../../services/employee";
export default {
    props: ["employee"],
    methods: {
        fioOfEmployee() {
            return !this.employee
                ? ""
                : `${this.employee.surname || ""} ${this.employee.name ||
                      ""} ${this.employee.lastname || ""}`;
        },
        downloadFile(id) {
            empService.downloadFile(id);
        },
        closeModal() {
            this.$bvModal.hide("employeeFilesShowModal");
        }
    }
};
</script>
