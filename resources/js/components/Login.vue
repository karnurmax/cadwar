<template>
<b-container>
  <b-row>
  <b-col class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
    <b-card class="mt-3" header="Войти">
        <b-form @submit="onSubmit">
        <b-form-group
            id="input-group-1"
            label="Электронная почта:"
            label-for="input-1"
        >
            <b-form-input
            id="input-1"
            v-model="form.email"
            type="email"
            required
            placeholder="my-super@email.com"
            ></b-form-input>
        </b-form-group>

        <b-form-group 
            id="input-group-2" 
            label="Пароль:" 
            label-for="input-2">
            <b-form-input
            type="password"
            id="input-2"
            v-model="form.name"
            required></b-form-input>
        </b-form-group>

        <b-button type="button" variant="primary" class="btn-block col-8 offset-2">Войти</b-button>
        </b-form>
    
    </b-card>
  </b-col>
  </b-row>
</b-container>  
</template>

<script>
  export default {
    data() {
      return {
        form: {
          email: '',
          name: '',
          food: null,
          checked: []
        },
        foods: [{ text: 'Select One', value: null }, 'Carrots', 'Beans', 'Tomatoes', 'Corn'],
        show: true
      }
    },
    methods: {
      onSubmit(evt) {
        evt.preventDefault()
        alert(JSON.stringify(this.form))
      },
      onReset(evt) {
        evt.preventDefault()
        // Reset our form values
        this.form.email = ''
        this.form.name = ''
        this.form.food = null
        this.form.checked = []
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      }
    }
  }
</script>