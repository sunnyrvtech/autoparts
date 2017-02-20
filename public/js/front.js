var app = angular.module('autoPartApp', ['ngSanitize'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('autoPartController', ['$scope', '$http', '$sce', function ($scope, $http, $sce) {

        $scope.todos = [];
        $scope.loading = false;

        $scope.init = function () {
            //$scope.loading = true;
            $http.get(BaseUrl + '/api').
                    then(function (data, status, headers, config) {
                        //$scope.render_html = data.data;
                        $scope.render_html = $sce.trustAsHtml(data.data);
                        // $scope.loading = false;

                    });
        }

        $scope.login = function () {
            //$scope.loading = true;
            $scope.animated = '';
            $http.get(BaseUrl + '/api/login').
                    then(function (data, status, headers, config) {
                        $scope.animated = 'slideInDown';
                        $scope.render_html = $sce.trustAsHtml(data.data);
                        //$scope.loading = false;

                    });
        }

        $scope.addTodo = function () {
            $scope.loading = true;

            $http.post(BaseUrl + '/api/todos', {
                title: $scope.todo.title,
                done: 1
            }).then(function (data, status, headers, config) {
                $scope.todos.push(data.data);
                $scope.todo = '';
                $scope.loading = false;

            });
        };

        $scope.updateTodo = function (todo) {
            $scope.loading = true;

            $http.put(BaseUrl + '/api/todos/' + todo.id, {
                title: todo.title,
                done: todo.done
            }).then(function (data, status, headers, config) {
                todo = data;
                $scope.loading = false;

            });
            ;
        };

        $scope.deleteTodo = function (index) {
            $scope.loading = true;

            var todo = $scope.todos[index];

            $http.delete(BaseUrl + '/api/todos/' + todo.id)
                    .then(function () {
                        $scope.todos.splice(index, 1);
                        $scope.loading = false;

                    });
            ;
        };


        $scope.init();

    }]);