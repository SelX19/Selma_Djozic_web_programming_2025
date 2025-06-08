
var UserService = {
    init: function () { //init method checks if the user is already logged in - via user_token in localStorage
        var token = localStorage.getItem("user_token");
        if (token && token !== undefined) {
            window.location.replace("index.html");

        }
        else {
            $("#profileBtn").hide();
            $("#loginBtn").show();

        }
        $("#logInForm").validate({ //jQuery validate plugin
            submitHandler: function (form, event) {
                event.preventDefault();
                var entity = Object.fromEntries(new FormData(form).entries());
                UserService.login(entity);
            },
        });
    },
    login: function (entity) {
        RestClient.post("auth/login", entity, function (response) {
            if (response && response.data && response.data.token) {
                localStorage.setItem("user_token", response.data.token);
                window.location.replace("index.html"); // Redirect as needed
            } else {
                alert("Login failed: No token received.");
            }
        }, function (err) {
            alert("Login failed: Invalid credentials or server error.");
            console.log("Login error:", err);
        });
    },


    logout: function () {
        localStorage.clear();
        window.location.hash = "#logIn";
    },
    generateMenuItems: function () {
        const token = localStorage.getItem("user_token");//retrieves token
        const user = Utils.parseJwt(token).user;  //decodes it


        if (user && user.role) {
            let nav = "";
            let main = "";
            switch (user.role) {
                case Constants.USER_ROLE: //dynamically generating nav menu itemsand page sections that shall be displayed for that role
                    nav = '<li class="nav-item mx-0 mx-lg-1">' +
                        '<a class="nav-link py-3 px-0 px-lg-3 rounded " href="#students">Students</a>' +
                        '</li>' +
                        '<li class="nav-item mx-0 mx-lg-1">' +
                        '<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#highcharts">Highcharts</a>' +
                        '</li>' +
                        '<li class="nav-item mx-0 mx-lg-1">' +
                        '<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#forms">Forms</a>' +
                        '</li>' +
                        '<li>' +
                        '<button class="btn btn-primary" onclick="UserService.logout()">Logout</button>'
                    '</li>';
                    $("#tabs").html(nav);
                    main =
                        '<section id="highcharts"></section>' +
                        '<section id="forms"></section>' +
                        '<section id="view_more"></section>' +
                        '<section id="students" data-load="students.html"></section>';
                    $("#spapp").html(main);
                    break;
                case Constants.ADMIN_ROLE:
                    nav = '<li class="nav-item mx-0 mx-lg-1">' +
                        '<a class="nav-link py-3 px-0 px-lg-3 rounded " href="#students">Students</a>' +
                        '</li>' +
                        '<li class="nav-item mx-0 mx-lg-1">' +
                        '<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#highcharts">Highcharts</a>' +
                        '</li>' +
                        '<li class="nav-item mx-0 mx-lg-1">' +
                        '<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#forms">Forms</a>' +
                        '</li>' +
                        '<li class="nav-item mx-0 mx-lg-1">' +
                        '<a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#forms">FormsADMIN</a>' +
                        '</li>' +
                        '<li>' +
                        '<button class="btn btn-primary" onclick="UserService.logout()">Logout</button>'
                    '</li>';
                    $("#tabs").html(nav);
                    main =
                        '<section id="highcharts"></section>' +
                        '<section id="forms"></section>' +
                        '<section id="view_more"></section>' +
                        '<section id="students" data-load="students.html"></section>';
                    $("#spapp").html(main);
                    break;
                default:
                    $("#tabs").html(nav);
                    $("#spapp").html(main);
            }
        } else {
            window.location.replace("login.html"); //person redirected to log in if no corespondant role found (not registered)
        }
    }
};
