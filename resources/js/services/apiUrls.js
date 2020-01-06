export default {
    API_URL: location.origin,
    login: "auth/login",
    register: "auth/register",
    resetPassword: "auth/reset",
    crud: "crud",
    employeeFilesUpload: "employees/{id}/files/upload",
    getEmployeesWithFiles: "employees/get/with-files",
    employeeDownloadFile:"employees/files/download/{id}"
};
