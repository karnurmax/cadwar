<template>
<div class="col-main col-sm-12 col-xs-12">
    <div class="my-account">
    <div class="page-title">
        <h2>Histories</h2>
    </div>
    <div class="orders-list table-responsive"> 
        <table class="table table-bordered cart_summary table-striped">
        <thead>
            <tr> 
            <th> number</th>
            <th>??</th>
            <th>??</th>
            <th>??</th>
            <th>??</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(order,ind) in 5"> 
            <td>{{ind+1}}</td>
            <td>??</td>
            <td>??</td>
            <td>??</td>
            <td class="action">
                <div style="display:flex;">
                    <router-link :to="{name:'order_form', params:{action_type:'view',id:order.id}}" class="btn btn-info btn-xs" title="view"><i class="fa fa-eye"></i></router-link>
                    <router-link :to="{name:'order_form', params:{action_type:'edit',id:order.id}}" class="btn btn-success btn-xs" title="edit"><i class="fa fa-pencil"></i></router-link>
                    <a href="javascript:;" @click="deleteOrder(order.id)" class="btn btn-danger btn-xs" title="todelete"><i class="fa fa-close"></i></a>
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
}
</script>
