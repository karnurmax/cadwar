<template>
    <b-modal id="basesEditModal" title="Редактрование базы" @ok="saveItem">
        <b-form @submit="onSubmit">
            <b-form-group
                id="input-group-1"
                label="Название :"
                label-for="input-1"
            >
                <b-form-input
                    id="input-1"
                    v-model="item.name"
                    type="text"
                    required
                    placeholder="Введите название"
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
    props: ['item'],
    methods: {
        onSubmit() {},
        saveItem(e) {
            e.preventDefault();
            crudService.updateItem("bases", this.item).then(res => {
                if (res.status === 200) {
                    this.$emit("updated", res.data);
                    this.$bvModal.hide("basesEditModal");
                } else {
                    window.alert("Ошибка");
                }
            });
        }
    }
};
</script>
