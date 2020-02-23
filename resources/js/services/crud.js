import http from "./http";
import apiUrls from "./apiUrls";
export default {
    getAll(tableName) {
        return http.get(`${apiUrls.crud}/${tableName}`);
    },
    getById(tableName, id) {
        return http.get(`${apiUrls.crud}/${tableName}/${id}`);
    },
    postNewItem(tableName, item) {
        return http.post(`${apiUrls.crud}/${tableName}`, item);
    },
    updateItem(tableName, item) {
        return http.put(`${apiUrls.crud}/${tableName}`, item);
    },
    removeItem(tableName, id) {
        return http.remove(`${apiUrls.crud}/${tableName}/${id}`);
    },
    getDistinct(tableName, column) {
        return http.get(`${apiUrls.getDistinctUrl}/${tableName}/${column}`);
    }
};
