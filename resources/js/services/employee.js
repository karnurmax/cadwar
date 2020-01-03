import http from "./http";
import apiUrls from "./apiUrls";
export default {
    uploadFile(userId, files) {
        let formData = new FormData();
        formData.append("files[]", files);

        return http.post(
            apiUrls.employeeFilesUpload.replace("{id}", userId),
            formData,
            {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }
        );
    }
};
