export default [
    {
        path: '/', component: require('./components/App.vue').default,
        children: [
            { path: '/databases', name:'databases', component: require('./components/Databases.vue').default },
            { path: '/employees', name:'employees', component: require('./components/Employees.vue').default },
            { path: '/histories', name:'histories',  component: require('./components/Histories.vue').default },
            { path: '/about', name:'about', component: require('./components/About.vue').default },

        ]
    }, 
    {
        path: '/login', component: require('./components/Login.vue').default
    }, 
    {
        path: '/form', component: require('./components/Form.vue').default
    }, 
    {
        path: '/register', component: require('./components/Register.vue').default
    }, 
    {
        path: '*', component: require('./components/NotFound404.vue').default
    },
]