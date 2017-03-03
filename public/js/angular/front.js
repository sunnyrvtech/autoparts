var app = angular.module('autoPartApp', ['ngSanitize'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('autoPartController', ['$scope', '$http', '$sce', '$compile', '$timeout', function ($scope, $http, $sce, $compile, $timeout) {

        $scope.login = {};
        $scope.loading = false;
        $("#loaderOverlay").show();
        $("#alert_loading").show();
        $scope.alert_loading = false;

        $scope.init = function () {
            //$scope.loading = true;
            $http.get(BaseUrl + '/').
                    then(function (data, status, headers, config) {
                        //$scope.render_html = data.data;
                        $scope.render_html = $sce.trustAsHtml(data.data);
                        // $scope.loading = false;

                    });
        }

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
        };

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
                        window.location=BaseUrl+"/";
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
        };

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
        };

        $scope.updateTodo = function (todo) {
            $scope.loading = true;

            $http.put(BaseUrl + '/todos/' + todo.id, {
                title: todo.title,
                done: todo.done
            }).then(function (data, status, headers, config) {
                todo = data;
                $scope.loading = false;

            });
        };

        $scope.deleteTodo = function (index) {
            $scope.loading = true;

            var todo = $scope.todos[index];

            $http.delete(BaseUrl + '/todos/' + todo.id)
                    .then(function () {
                        $scope.todos.splice(index, 1);
                        $scope.loading = false;

                    });
            ;
        };
        // hide alert after 5 second
        $scope.alertHide = function () {
            $timeout(function () {
                $scope.alert_loading = false;
            }, 8000);
        };
        
        $scope.init();

    }]);