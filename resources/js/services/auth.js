import User from "../models/user";
import http from "./http";
import apiUrls from "./apiUrls";
import { userInfo } from "os";
export default {
    register(data) {
        window.console.log('register',data);
        return http.post(apiUrls.register, data);
    },
    getCurrentUser() {
        return new User("qwe@qwe.qwe", "user1");
    }
};
