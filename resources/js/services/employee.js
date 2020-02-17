import http from "./http";
import apiUrls from "./apiUrls";
export default {
    uploadFile(userId, files) {
        return http.uploadFile(
            apiUrls.employeeFilesUpload.replace("{iin}", userId),
            files
        );
    },
    removeFileOnServer(id) {
        return http.post(apiUrls.employeeFilesRemove.replace("{id}", id));
    },
    removeFileListOnServer(ids) {
        return http.post(apiUrls.employeeFileListRemove, { ids });
    },
    getAllWithFiles() {
        return http.get(apiUrls.getEmployeesWithFiles);
    },
    downloadFile(id) {
        return http.get(apiUrls.employeeDownloadFile.replace("{id}", id));
    }
};
