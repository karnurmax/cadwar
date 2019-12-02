<template>
    <b-container>
        <b-row>
            <b-col class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                <b-card class="mt-3" header="Регистрация">
                    <b-form>
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
                                :state="emailValidation"
                                placeholder="my-super@email.com"
                            ></b-form-input>
                            <b-form-invalid-feedback :state="emailValidation">
                                введенный email некорректен
                            </b-form-invalid-feedback>
                        </b-form-group>

                        <b-form-group
                            id="input-group-2"
                            label="Пароль:"
                            label-for="input-2"
                        >
                            <b-form-input
                                type="password"
                                id="input-2"
                                v-model="form.password"
                                required
                                :state="passwordValidation"
                            ></b-form-input>
                            <b-form-invalid-feedback
                                :state="passwordValidation"
                            >
                                длина пароля должна быть равно или больше шести
                                символов
                            </b-form-invalid-feedback>
                        </b-form-group>

                        <b-form-group
                            id="input-group-3"
                            label="Подтверждение:"
                            label-for="input-3"
                        >
                            <b-form-input
                                type="password"
                                id="input-3"
                                v-model="form.confirm"
                                required
                                :state="confirmValidation"
                            ></b-form-input>
                            <b-form-invalid-feedback :state="confirmValidation">
                                подтверждение не совпадает с паролем
                            </b-form-invalid-feedback>
                        </b-form-group>

                        <b-button
                            type="button"
                            variant="primary"
                            class="btn-block col-8 offset-2"
                            @click="register"
                            >Регистрация</b-button
                        >
                    </b-form>
                </b-card>
            </b-col>
            <b-col class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                <b-link to="/login">Уже есть аккаунт? Войдите</b-link>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import authService from "../services/auth";
export default {
    data() {
        return {
            mustBeValidated: false,
            form: {
                email: "",
                password: "",
                confirm: ""
            }
        };
    },
    methods: {
        register() {
            this.mustBeValidated = true;
            if (
                !this.emailValidation ||
                !this.passwordValidation ||
                !this.confirmValidation
            )
                return;
            authService.register(this.form).then(res => {
                window.console.log(res);
            });
        }
    },
    computed: {
        emailValidation() {
            if (!this.mustBeValidated) return null;
            let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(this.form.email).toLowerCase());
        },
        passwordValidation() {
            if (!this.mustBeValidated) return null;
            return this.form.password.length >= 6;
        },
        confirmValidation() {
            return !this.mustBeValidated
                ? null
                : this.form.password
                ? this.form.password === this.form.confirm
                : null;
        }
    }
};
</script>
