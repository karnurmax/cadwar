<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="dark">
            <b-navbar-brand href="#">CADWAR</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item>
                        <router-link
                            :to="{ name: 'employees' }"
                            title="Работники"
                            >Работники</router-link
                        >
                    </b-nav-item>
                    <b-nav-item>
                        <router-link :to="{ name: 'histories' }" title="Истории"
                            >Истории</router-link
                        >
                    </b-nav-item>
                    <b-nav-item>
                        <router-link
                            :to="{ name: 'statementTemplates' }"
                            title="Истории"
                            >Шаблоны заявлении</router-link
                        >
                    </b-nav-item>
                    <b-nav-item>
                        <router-link
                            :to="{ name: 'loadData' }"
                            title="Загрузить Базу"
                            >Загрузить Базу</router-link
                        >
                    </b-nav-item>
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-nav-form style="display:none;">
                        <b-form-input
                            size="sm"
                            class="mr-sm-2"
                            placeholder="Поиск"
                        ></b-form-input>
                        <b-button size="sm" class="my-2 my-sm-0" type="submit"
                            >Поиск</b-button
                        >
                    </b-nav-form>

                    <b-nav-item-dropdown
                        text="Язык"
                        right
                        style="display:none;"
                    >
                        <b-dropdown-item href="#">RU</b-dropdown-item>
                        <b-dropdown-item href="#">Скоро..)</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                        <template v-slot:button-content>
                            <em>{{userEmail}}</em>
                        </template>
                        <b-dropdown-item href="#">Профиль</b-dropdown-item>
                        <b-dropdown-item href="#" @click="logout"
                            >Выйти</b-dropdown-item
                        >
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: null
        };
    },
    created() {
        this.user = window.user;
    },
    methods: {
        logout() {
            window.document.getElementById("logout-form").submit();
        }
    },
    computed: {
        userEmail() {
            if (!this.user) return "";
            return !!this.user.email ? this.user.email : "";
        }
    }
};
</script>
