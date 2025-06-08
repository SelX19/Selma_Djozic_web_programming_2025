let Utils = {
    datatable: function (table_id, columns, data, pageLength = 15) {
        if ($.fn.dataTable.isDataTable("#" + table_id)) {
            $("#" + table_id).DataTable().destroy();
        }
        $("#" + table_id).DataTable({
            data: data,
            columns: columns,
            pageLength: pageLength,
            lengthMenu: [2, 5, 10, 15, 25, 50, 100, "All"],
        });
    },

    parseJwt: function (token) {
        if (!token) return null;
        try {
            const base64Url = token.split(".")[1];
            const base64 = base64Url.replace(/-/g, "+").replace(/_/g, "/");
            const jsonPayload = decodeURIComponent(
                atob(base64)
                    .split("")
                    .map(function (c) {
                        return "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2);
                    })
                    .join("")
            );
            return JSON.parse(jsonPayload);
        } catch (e) {
            console.error("Invalid JWT token", e);
            return null;
        }
    },

    isAdmin: function () {
        const token = localStorage.getItem("user_token");
        const user = Utils.parseJwt(token);
        return user && user.role === "admin";
    },

    isLoggedIn: function () {
        const token = localStorage.getItem("user_token");
        const payload = this.parseJwt(token);
        return token && payload && (Date.now() / 1000) < payload.exp;
    }

};

