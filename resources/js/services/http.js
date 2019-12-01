import axios from "axios";
import apiUrl from "./apiUrls";
axios.defaults.baseURL = apiUrl.API_URL;

export default {
    get(url) {
        return axios.get(url).catch(err => {
            console.error(err);
        });
    },
    post(url, data) {
        return axios.post(url, data).catch(err => {
            console.error(err);
        });
    },
    put(url, data) {
        return axios.put(url, data).catch(err => {
            console.error(err);
        });
    },
    remove(url) {
        return axios.delete(url).catch(err => {
            console.error(err);
        });
    }
};
