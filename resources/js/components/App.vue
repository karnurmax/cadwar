<template>
<div>
    <b-navbar toggleable="lg" type="light" variant="info">
    <b-navbar-brand href="#">CADWAR</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
            <b-nav-item href="#">Базы</b-nav-item>
            <b-nav-item href="#">Участники</b-nav-item>
            <b-nav-item href="#">Истории</b-nav-item>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">
            <b-nav-form>
                <b-form-input size="sm" class="mr-sm-2" placeholder="Поиск"></b-form-input>
                <b-button size="sm" class="my-2 my-sm-0" type="submit">Поиск</b-button>
            </b-nav-form>

            <b-nav-item-dropdown text="Язык" right>
                <b-dropdown-item href="#">RU</b-dropdown-item>
                <b-dropdown-item href="#">Скоро..)</b-dropdown-item>
            </b-nav-item-dropdown>

            <b-nav-item-dropdown right>
                <!-- Using 'button-content' slot -->
                <template v-slot:button-content>
                <em>Пользователь</em>
                </template>
                <b-dropdown-item href="#">Профиль</b-dropdown-item>
                <b-dropdown-item href="#">Выйти</b-dropdown-item>
            </b-nav-item-dropdown>

        </b-navbar-nav>
    </b-collapse>
    </b-navbar>
    <router-view></router-view>
</div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
