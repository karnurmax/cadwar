import User from "../models/user";
import http from "./http";
import apiUrls from "./apiUrls";

export default {
    register(data) {
        return http.post(apiUrls.register, data);
    },
    login(data) {
        return http.post(apiUrls.login, data);
    },
    reset(data) {
        return http.post(apiUrls.resetPassword, data);
    },
    getCurrentUser() {
        return window.user;
        //return http.get(apiUrls.getCurrentUser);
    }
};
