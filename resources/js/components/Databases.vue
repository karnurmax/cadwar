<template>
    <div class="col-main col-sm-12 col-xs-12">
        <div class="my-account">
            <div class="page-title">
                <h2>Базы данных</h2>
            </div>
            <div class="orders-list table-responsive">
                <table class="table table-bordered cart_summary table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>
                                Наименование
                                <font-awesome-icon icon="database" />
                            </th>
                            <th>
                                Количество пользователей
                                <font-awesome-icon icon="users" />
                            </th>
                            <th>
                                Дата создания
                                <font-awesome-icon icon="calendar" />
                            </th>
                            <th>Действия <font-awesome-icon icon="pen" /></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, ind) in 5">
                            <td>{{ ind + 1 }}</td>
                            <td>Abu dhabbi</td>
                            <td>7</td>
                            <td>today<i class="fas fa-coffee"></i></td>
                            <td class="action">
                                <div style="display:flex;">
                                    <router-link
                                        :to="{
                                            name: 'order_form',
                                            params: {
                                                action_type: 'view',
                                                id: order.id
                                            }
                                        }"
                                        class="btn btn-info btn-xs"
                                        title="view"
                                        ><i class="fas fa-eye"></i
                                    ></router-link>
                                    <router-link
                                        :to="{
                                            name: 'order_form',
                                            params: {
                                                action_type: 'edit',
                                                id: order.id
                                            }
                                        }"
                                        class="btn btn-success btn-xs"
                                        title="edit"
                                        ><i class="fas fa-pencil"></i
                                    ></router-link>
                                    <a
                                        href="javascript:;"
                                        @click="deleteOrder(order.id)"
                                        class="btn btn-danger btn-xs"
                                        title="todelete"
                                        ><i class="fa fa-close"></i
                                    ></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--app-loader v-if="isLoading"></app-loader-->
    </div>
</template>

<script>
export default {
    data() {
        return {
            query_id: null,
            order_id: null,
            order_date: null,
            order_status: {
                value: "",
                kz: "",
                ru: "",
                en: ""
            },
            order_status_date: null,
            order_sum: null,
            showResult: false,
            error: false,
            attemptSubmit: false,
            success: false,
            products: null,
            showQuickView: false,
            quickViewProduct: null,
            disabled: true
        };
    }
};
</script>
