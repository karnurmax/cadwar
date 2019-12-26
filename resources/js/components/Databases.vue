<template>
    <div class="container">
        <div class="row">
            <div class="page-title">
                <p>
                    <h2>Базы данных</h2>
                    <b-button @click="editItem(item)">
                                <font-awesome-icon icon="pencil-alt" />
                            </b-button>
                </p>
            </div>
            
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width:60px;"></th>
                        <th>Наименование</th>
                        <th style="display:none">Количество пользователей</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, idx) in list">
                        <td>{{ idx + 1 }}</td>
                        <td>{{item.name}}</td>
                        <td style="display:none">7</td>
                        <td>today</i></td>
                        <td class="action">
                            <b-button @click="editItem(item)">
                                <font-awesome-icon icon="pencil-alt" />
                            </b-button>
                            <b-button variant="danger" @click="removeItem(item)">
                                <font-awesome-icon icon="trash" />
                            </b-button>
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </div>
        <!--app-loader v-if="isLoading"></app-loader-->
    </div>
</template>

<script>
export default {
    data() {
        return {
            list:[{},{},{}],
            selectedItem:null,
        };
    },
    methods:{
        editItem(item){
            window.console.log(item);
        },
        removeItem(item){
            window.console.log(item);
        },
    }
};
</script>
