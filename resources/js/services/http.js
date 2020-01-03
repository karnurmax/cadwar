import axios from "axios";
import apiUrl from "./apiUrls";
axios.defaults.baseURL = apiUrl.API_URL;
axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
};
// document.querySelector('meta[name="csrf-token"]').content
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
    },
    uploadFile(url, files) {
        let formData = new FormData();
        for (let i = 0; i < files.length; i++)
            formData.append("files[" + i + "]", files[i]);

        return axios.post(url, formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    }
};
