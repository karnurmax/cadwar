export default {
    API_URL: location.origin,
    login: "auth/login",
    register: "auth/register",
    resetPassword: "auth/reset",
    crud: "crud",
    employeeFilesUpload: "employees/{iin}/files/upload",
    getEmployeesWithFiles: "employees/get/with-files",
    employeeDownloadFile: "employees/files/download/{id}",
    employeeFileRemove: "employees/files/remove/{id}",
    employeeFileListRemove: "employees/files/removelist",
    getCurrentUser: "getCurrentUser",
    loadCSV: "uploaddb/csv",
    getDistinctUrl: "distinct"
};
