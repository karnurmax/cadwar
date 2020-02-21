import apiUrls from "./apiUrls";
import http from "./http";

export default {
    loadCSV(data) {
        return http.uploadFile(apiUrls.loadCSV, data);
    }
};
