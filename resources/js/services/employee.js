import http from "./http";
import apiUrls from "./apiUrls";
export default {
    uploadFile(userId, files) {
        return http.uploadFile(
            apiUrls.employeeFilesUpload.replace("{id}", userId),
            files
        );
    },
    removeFileOnServer(id) {
        return http.post(apiUrls.employeeFilesRemove.replace("{id}", id));
    },
    getAllWithFiles() {
        return http.get(apiUrls.getEmployeesWithFiles);
    },
    downloadFile(id) {
        return http.get(apiUrls.employeeDownloadFile.replace("{id}", id));
    }
};
