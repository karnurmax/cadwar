import axios from 'axios';
import apiUrl from './apiUrls';
axios.defaults.baseURL = apiUrl.API_URL;
export default {
    get(url) {
        return axios.get(url);
    },
    post(url, data) {
        return axios.post(url, data);
    },
    put(url, data) {
        return axios.put(url, data);
    },
    remove(url) {
        return axios.delete(url);
    }
}