var dropzone = new Dropzone(".create__file", {
    url: "/tasks/load-files",
    uploadMultiple: true,
    paramName: "files",
});