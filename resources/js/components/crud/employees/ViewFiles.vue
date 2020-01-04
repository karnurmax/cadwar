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
                <b-link>
                    <font-awesome-icon icon="download" />
                </b-link>
            </b-list-group-item>
        </b-list-group>
    </b-modal>
</template>

<script>
import crudService from "../../../services/crud";
export default {
    props: ["employee"],
    methods: {
        fioOfEmployee() {
            return !this.employee
                ? ""
                : `${this.employee.surname || ""} ${this.employee.name ||
                      ""} ${this.employee.lastname || ""}`;
        }
    }
};
</script>
