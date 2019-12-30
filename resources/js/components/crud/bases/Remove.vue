<template>
    <b-modal id="basesRemoveModal" title="Удаление базы" @ok="saveItem">
        <b-form @submit="onSubmit">
            <b-form-group
                id="input-group-1"
                label="Название :"
                label-for="input-1"
            >
                <b-form-input
                    disabled
                    id="input-1"
                    v-model="item.name"
                    type="text"
                    required
                ></b-form-input>
            </b-form-group>

            <template v-slot:modal-footer>
                <b-button type="button">Отмена</b-button>
                <b-button type="submit" variant="danger">Удалить</b-button>
            </template>
        </b-form>
    </b-modal>
</template>

<script>
import crudService from "../../../services/crud";
export default {
    props: ["item"],
    methods: {
        onSubmit() {},
        saveItem(e) {
            e.preventDefault();
            crudService.removeItem("bases", this.item.id).then(res => {
                if (res.status === 200) {
                    this.$emit("removed", res.data); //id
                    this.$bvModal.hide("basesRemoveModal");
                } else {
                    window.alert("Ошибка");
                }
            });
        }
    }
};
</script>
