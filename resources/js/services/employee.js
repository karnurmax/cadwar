import http from "./http";
import apiUrls from "./apiUrls";
export default {
    uploadFile(userId, files) {
        return http.uploadFile(
            apiUrls.employeeFilesUpload.replace("{id}", userId),
            files
        );
    }
};
