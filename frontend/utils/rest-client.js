let RestClient = {
    get: function (url, callback, error_callback, options = {}) {
        $.ajax({
            url: Constants.PROJECT_BASE_URL + url, //url to backend
            type: "GET",
            beforeSend: function (xhr) {
                const token = localStorage.getItem("user_token");
                if (token) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                }
                if (options.headers) {
                    for (const headerName in options.headers) {
                        xhr.setRequestHeader(headerName, options.headers[headerName]);
                    }
                }
            },
            success: function (response) {
                if (callback) callback(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // handling token expiration, potentially causing 401, unauthorized access
                if (jqXHR.status === 401) {
                    console.warn("Token expired or invalid. Logging out...");
                    localStorage.removeItem("user_token");
                    window.location.href = "#logIn"; // or "login.html" if using static page
                    return;
                }
                if (error_callback) error_callback(jqXHR);
            },
        });
    },
    request: function (url, method, data, callback, error_callback, options = {}) { //then to make a request by different methods
        $.ajax({
            url: Constants.PROJECT_BASE_URL + url,
            type: method,
            beforeSend: function (xhr) {
                const token = localStorage.getItem("user_token");
                if (token) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                }
                if (options.headers) {
                    for (const headerName in options.headers) {
                        xhr.setRequestHeader(headerName, options.headers[headerName]);
                    }
                }
            },
            data: data,
        })
            .done(function (response, status, jqXHR) {
                if (callback) callback(response);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 401) {
                    console.warn("Token expired or invalid. Logging out...");
                    localStorage.removeItem("user_token");
                    window.location.href = "#logIn";
                    return;
                }
                if (error_callback) {
                    error_callback(jqXHR);
                } else {
                    toastr.error(jqXHR.responseJSON.message);
                }
            });
    }, //shortcuts for each request method
    post: function (url, data, callback, error_callback, options = {}) {
        RestClient.request(url, "POST", data, callback, error_callback);
    },
    delete: function (url, data, callback, error_callback, options = {}) {
        RestClient.request(url, "DELETE", data, callback, error_callback);
    },
    patch: function (url, data, callback, error_callback, options = {}) {
        RestClient.request(url, "PATCH", data, callback, error_callback);
    },
    put: function (url, data, callback, error_callback, options = {}) {
        RestClient.request(url, "PUT", data, callback, error_callback);
    },
};
