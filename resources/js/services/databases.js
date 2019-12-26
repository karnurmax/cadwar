import Database from "../models/databases";
import http from "./http";
import apiUrls from "./apiUrls";

export default {
    get(data) {
        return http.get(apiUrls.getDatabases, data);
    },
    post(data) {
        return http.post(apiUrls.login, data);
    },
    reset(data) {
        return http.post(apiUrls.resetPassword, data);
    },
    getCurrentUser() {
        return new User("qwe@qwe.qwe", "user1");
    }
};
