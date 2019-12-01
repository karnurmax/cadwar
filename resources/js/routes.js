export default [
    {
        path: '/', component: require('./components/App.vue').default,
        children: [
            { path: '/databases', component: require('./components/Databases.vue').default },
            { path: '/persons', component: require('./components/Persons.vue').default },
            { path: '/histories', component: require('./components/Histories.vue').default },
            { path: '/about', component: require('./components/About.vue').default },

        ]
    }, {
        path: '/login', component: require('./components/Login.vue').default
    }, {
        path: '/register', component: require('./components/Register.vue').default
    }, {
        path: '*', component: require('./components/NotFound404.vue').default
    },
]