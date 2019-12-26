import http from "./http";
import apiUrls from "./apiUrls";
export default {
    getAll(tableName) {
        return http.get(`${apiUrls.crudGetAll}/${tableName}`);
    },
    getById(tableName, id) {
        return http.get(`${apiUrls.crudGetById}/${tableName}/${id}`);
    },
    postNewItem(tableName, item) {
        return http.post(`${apiUrls.crudPostItem}/${tableName}`, item);
    },
    updateItem(tableName, item) {
        return http.put(`${apiUrls.crudPostItem}/${tableName}`, item);
    },
    removeItem(tableName, id) {
        return http.remove(`${apiUrls.crudPostItem}/${tableName}/${id}`);
    }
};
