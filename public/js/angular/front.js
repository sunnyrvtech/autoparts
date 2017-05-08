var app = angular.module('autoPartApp', ['ngSanitize'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('autoPartController', ['$scope', '$http', '$sce', '$compile', '$timeout', function ($scope, $http, $sce, $compile, $timeout) {

        $scope.login = {};
        $scope.shipping = {};
        $scope.billing = {};
        $scope.cart = {};
        $scope.loading = false;
        $("#loaderOverlay").show();
        $("#alert_loading").show();
        $scope.alert_loading = false;

//        $scope.init = function () {
//            //$scope.loading = true;
//            $http.get(BaseUrl + '/').
//                    then(function (data, status, headers, config) {
//                        //$scope.render_html = data.data;
//                        //$scope.render_html = $sce.trustAsHtml(data.data);
//                        // $scope.loading = false;
//
//                    });
//        }

        $scope.login = function () {
            //$scope.loading = true;
            //$scope.animated = '';
            $http.get(BaseUrl + '/login').
                    then(function (data, status, headers, config) {
//                        $scope.animated = 'slideInDown';
                        var $e1 = $('#content').html(data.data);
                        $compile($e1)($scope);
                        //$scope.render_html = $sce.trustAsHtml(data.data);

                        //$scope.loading = false;
                    });
        }

        $scope.register = function () {
            //$scope.loading = true;
            //$scope.animated = '';
            $http.get(BaseUrl + '/register').
                    then(function (data, status, headers, config) {
//                        $scope.animated = 'slideInDown';
                        var $e1 = $('#content').html(data.data);
                        $compile($e1)($scope);
                        //$scope.render_html = $sce.trustAsHtml(data.data);

                        //$scope.loading = false;
                    });
        }

        $scope.submitLogin = function (isValid) {
            //$scope.loading = true;
            // check to make sure the form is completely valid
            if (isValid) {
                $http({
                    method: 'POST',
                    url: BaseUrl + '/login',
                    data: 'email=' + $scope.login.email + '&password=' + $scope.login.password,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = '';
                    $scope.alert_messages = 'Login successfully!Redirecting.....';
                    $(window).scrollTop(0);
                    $timeout(function () {
                        window.location = BaseUrl + "/my-account";
                    }, 2000);

                    //console.log(data);
                    // $scope.push(data.data);
//                $scope.loading = false;

                }, function errorCallback(data) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-danger';
                    $scope.alertLabel = 'Error!';
                    $scope.alert_messages = data.data.error;
                    $scope.alertHide();
                    $(window).scrollTop(0);
                });
            }
        }

        $scope.submitRegister = function (isValid) {
            $scope.alert_loading = false;
            // check to make sure the form is completely valid
            if (isValid) {
                $scope.loading = true;
                $http({
                    method: 'POST',
                    url: BaseUrl + '/register',
                    data: 'first_name=' + $scope.register.first_name + '&last_name=' + $scope.register.last_name + '&email=' + $scope.register.email + '&password=' + $scope.register.password + '&password_confirmation=' + $scope.register.password_confirmation,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = 'Success!';
                    $scope.alert_messages = data.data.messages;
                    $scope.alertHide();
                    $(window).scrollTop(0);
                    // $scope.push(data.data);
//                $scope.loading = false;

                }, function errorCallback(data) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-danger';
                    $scope.alertLabel = 'Error!';
                    if (data.data.error) {
                        $scope.alert_messages = data.data.error;
                    } else if (data.data.email) {
                        $scope.alert_messages = data.data.email[0];
                    } else if (data.data.password) {
                        $scope.alert_messages = data.data.password[0];
                    }
                    $scope.alertHide();
                    $(window).scrollTop(0);

                });
            }
        }

        $scope.submitChangePassword = function (isValid) {
            if (isValid) {
                $http({
                    method: 'POST',
                    url: BaseUrl + '/my-account/change-password',
                    data: 'password=' + $scope.password.password + '&confirm_password=' + $scope.password.confirm_password + '&current_password=' + $scope.password.current_password,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = 'Success!';
                    $scope.alert_messages = data.data.messages;
                    $scope.alertHide();
                    $(window).scrollTop(0);
                    // $scope.push(data.data);
//                $scope.loading = false;

                }, function errorCallback(data) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-danger';
                    $scope.alertLabel = 'Error!';
                    if (data.data.error) {
                        $scope.alert_messages = data.data.error;
                    } else if (data.data.password) {
                        $scope.alert_messages = data.data.password[0];
                    } else if (data.data.password) {
                        $scope.alert_messages = data.data.confirm_password[0];
                    }
                    $scope.alertHide();
                    $(window).scrollTop(0);

                });
            }
        }

        $scope.forgotPassword = function () {
            $http.get(BaseUrl + '/password/email').
                    then(function (data, status, headers, config) {
                        var $e1 = $('#content').html(data.data);
                        $compile($e1)($scope);

                    });
        }

        $scope.submitResetPasswordLink = function (isValid) {
            if (isValid) {
                $scope.loading = true;
                $http({
                    method: 'POST',
                    url: BaseUrl + '/password/email',
                    data: 'email=' + $scope.reset.email,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = 'Success!';
                    $scope.alert_messages = data.data.messages;
                    $(window).scrollTop(0);
                    //console.log(data);
                    // $scope.push(data.data);
//                $scope.loading = false;

                }, function errorCallback(data) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-danger';
                    $scope.alertLabel = 'Error!';
                    $scope.alert_messages = data.data.error;
                    $scope.alertHide();
                    $(window).scrollTop(0);
                });
            }
        }
        $scope.submitResetPassword = function (isValid) {
            if (isValid) {
                $scope.loading = true;
                $http({
                    method: 'POST',
                    url: BaseUrl + '/password/reset',
                    data: 'token=' + $scope.reset.token + '&email=' + $scope.reset.email + '&password=' + $scope.reset.password + '&password_confirmation=' + $scope.reset.password_confirmation,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = 'Success!';
                    $scope.alert_messages = data.data.messages + '!Redirecting.....';
                    $(window).scrollTop(0);
                    $timeout(function () {
                        window.location = BaseUrl + "/";
                    }, 2000);

                    //console.log(data);
                    // $scope.push(data.data);
//                $scope.loading = false;

                }, function errorCallback(data) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-danger';
                    $scope.alertLabel = 'Error!';
                    $scope.alert_messages = data.data.error;
                    $scope.alertHide();
                    $(window).scrollTop(0);
                });
            }
        }

        $scope.submitProfile = function (isValid) {
            var data = new FormData();
            if (isValid) {
                $scope.loading = true;
                data.append('profile_image', $("#profile_image")[0].files[0]);
                data.append('first_name', $scope.profile.first_name);
                data.append('last_name', $scope.profile.last_name);
                $http({
                    method: 'POST',
                    url: BaseUrl + '/my-account/profile',
                    data: data,
                    headers: {'Content-Type': undefined}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = 'Success!';
                    $scope.alert_messages = data.data.messages;
                    $scope.alertHide();
                    $(window).scrollTop(0);
                    $scope.loading = false;
                    $timeout(function () {
                        window.location = BaseUrl + "/my-account";
                    }, 200);

                }, function errorCallback(data) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-danger';
                    $scope.alertLabel = 'Error!';
                    if (data.data.first_name) {
                        $scope.alert_messages = data.data.first_name[0];
                    } else if (data.data.last_name) {
                        $scope.alert_messages = data.data.last_name[0];
                    }
                    $scope.alertHide();
                    $(window).scrollTop(0);

                });
            }
        }

        $scope.submitShipping = function (isValid) {
            var data = $scope.shipping;
//            console.log(this.shipping);
            if (isValid) {
                $scope.loading = true;
                $http({
                    method: 'POST',
                    url: BaseUrl + '/my-account/shipping',
                    data: data,
                    headers: {'Content-Type': 'application/json'}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = 'Success!';
                    $scope.alert_messages = data.data.messages;
                    $scope.alertHide();
                    $(window).scrollTop(0);
                    $scope.loading = false;
                    $timeout(function () {
                        window.location = BaseUrl + "/my-account";
                    }, 200);

                }, function errorCallback(data) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-danger';
                    $scope.alertLabel = 'Error!';
                    $scope.alert_messages = data.data;
                    $scope.alertHide();
                    $(window).scrollTop(0);

                });
            }
        }

        $scope.submitBilling = function (isValid) {
            var data = $scope.billing;
//            console.log(this.shipping);
            if (isValid) {
                $scope.loading = true;
                $http({
                    method: 'POST',
                    url: BaseUrl + '/my-account/billing',
                    data: data,
                    headers: {'Content-Type': 'application/json'}
                }).then(function (data, status, headers, config) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = 'Success!';
                    $scope.alert_messages = data.data.messages;
                    $scope.alertHide();
                    $(window).scrollTop(0);
                    $scope.loading = false;
                    $timeout(function () {
                        window.location = BaseUrl + "/my-account";
                    }, 200);

                }, function errorCallback(data) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-danger';
                    $scope.alertLabel = 'Error!';
                    $scope.alert_messages = data.data;
                    $scope.alertHide();
                    $(window).scrollTop(0);

                });
            }
        }

        $scope.submitCart = function (isValid, $productId) {

            $scope.cart.product_id = $productId;
            if ($scope.cart.quantity == undefined) {
                $scope.cart.quantity = 1;
            }
            var data = $scope.cart;
            if (isValid) {
                $scope.loading = true;
                $http({
                    method: 'POST',
                    url: BaseUrl + '/cart/add',
                    data: data,
                    headers: {'Content-Type': 'application/json'}
                }).then(function (data, status, headers, config) {
                    $scope.cart_count = parseInt($scope.cart_count) + parseInt($scope.cart.quantity); //  this is used to update cart count
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-success';
                    $scope.alertLabel = 'Success!';
                    $scope.alert_messages = data.data.messages;
                    $scope.alertHide();
                    $(window).scrollTop(0);
                    $scope.loading = false;
                }, function errorCallback(data) {
                    $scope.loading = false;
                    $scope.alert_loading = true;
                    $scope.alertClass = 'alert-danger';
                    $scope.alertLabel = 'Error!';
                    $scope.alert_messages = data.data.error;
                    $scope.alertHide();
                    $(window).scrollTop(0);

                });
            }
        }

        $scope.getProductByPage = function (element) {
            $http.get(element).
                    then(function (data, status, headers, config) {
                        var $e1 = $('#content').html(data.data);
                        $compile($e1)($scope);
                        window.history.pushState("", "", element);
                        $(window).scrollTop(0);
                    });

        }

        $scope.getProductVehicleData = function (element) {
            var id = element.attr('data-id');
            var URL = element.attr('data-url');
            var method = element.attr('data-method');
            if (method != 'vehicle_year') {
                element.closest(".ymm-select.open").find('.select-text').attr('data-id', id).text(element.text());
            } else {
                $(".dropdown-menu .ng-scope").remove();
                element.closest(".ymm-select.open").find('.select-text').attr('data-id', id).text(id);
            }
            if (method != 'vehicle_model') {
                $http({
                    method: 'POST',
                    url: URL,
                    data: {id: id},
                }).then(function (data, status, headers, config) {
                    if (method == 'vehicle_year') {
                        $scope.result_vehicle_company = data.data;
                    } else {
                        $scope.result_vehicle_model = data.data;
                    }

                });
            }

        }

        $scope.searchProduct = function (element) {
            var year = $("#vehicle_year").attr('data-id');
            var make_id = $("#vehicle_make").attr('data-id');
            var model_id = $("#vehicle_model").attr('data-id');
            var url = BaseUrl + '/products/search' + '?year=' + year + '&make_id=' + make_id + '&model_id=' + model_id;
            window.location.href = url;
        }

        $scope.getState = function ($countryId, $type) {
            if ($countryId != undefined) {
                $http({
                    method: 'POST',
                    url: BaseUrl + '/my-account/getState',
                    data: {id: $countryId}
                }).then(function (data) {
                    if ($type == 'states1') {
                        $scope.states1 = data.data;
                    } else {
                        $scope.states2 = data.data;
                    }
                }, function errorCallback(data) {

                });
            }
        }

        $scope.selectState = function ($countryId) {
            return $countryId;
        }

        $scope.setFile = function (element) {
            $scope.currentFile = element.files[0];
            var img = $('<img/>', {
                width: 200
            });
            var reader = new FileReader();
            reader.onload = function (event) {
                img.attr('src', event.target.result);
                $("#previewImage").html('<span class="image_prev">' + $(img)[0].outerHTML + '</span>');
            }
            // when the file is read it triggers the onload event above.
            reader.readAsDataURL(element.files[0]);
        }

        $scope.updateTodo = function (todo) {
            $scope.loading = true;

            $http.put(BaseUrl + '/todos/' + todo.id, {
                title: todo.title,
                done: todo.done
            }).then(function (data, status, headers, config) {
                todo = data;
                $scope.loading = false;

            });
        }

        $scope.deleteTodo = function (index) {
            $scope.loading = true;

            var todo = $scope.todos[index];

            $http.delete(BaseUrl + '/todos/' + todo.id)
                    .then(function () {
                        $scope.todos.splice(index, 1);
                        $scope.loading = false;

                    });
            ;
        }
        // hide alert after 5 second
        $scope.alertHide = function () {
            $timeout(function () {
                $scope.alert_loading = false;
            }, 8000);
        }

//        $scope.init();

    }]);