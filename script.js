/**
 * Created by qwant on 23.09.2015.
 */
var myApp = angular.module('myApp', []);

myApp.controller('MyCtrl', function ($scope, $http) {
    $scope.resetForm = function () {

        // init form
        $("#login").removeAttr('data-original-title').removeClass('has-success has-error');
        $("#password").removeAttr('data-original-title').removeClass('has-success has-error');
        $("#repassword").removeAttr('data-original-title').removeClass('has-success has-error');
        $("#phone").removeAttr('data-original-title').removeClass('has-success has-error');
        $("#invite").removeAttr('data-original-title').removeClass('has-success has-error');

    };

    $scope.isFormValid = function () {
        if ($("#login").hasClass('has-success') && $("#password").hasClass('has-success')
        && $("#repassword").hasClass('has-success') && $("#invite").hasClass('has-success')
            && !$("#phone").hasClass('has-error')) return false
        else return true;
    };

    $scope.submit = function (user) {

        // 1 - проверить на доступность invite  true | false

        $http.post('controllers/isInviteActive.php', {get: user.invite, post : user})
            .success(function (response) {
                user.response_invite = response;
                var dot = 'data-original-title';

                if (user.response_invite.invite == 'false') {
                    $("#invite").attr(dot,'Инвайт отсутствует в базе.').tooltip('show')
                        .addClass('has-error').removeClass('has-success');
                };
                if ((user.response_invite.invite == user.invite) && (user.response_invite.status==1)){
                    $("#invite").attr(dot,'Такой инвайт есть но истек.').tooltip('show')
                        .addClass('has-error').removeClass('has-success');
                }
                else {
                    $('#myModal').modal('hide');
                }
            })
            .error(function (response) {
                $scope.codeStatus = response || "Request failed";
                alert('Request failed');
            });

        // 2 - выкинуть user->all serialize на сервер post (пароль с логином зашифровать) запрос асинхронный


        // 3 - показать результат добавления (ок не ок)
    };

    $scope.changeLogin = function (login) {
        var expr = /^[a-zA-Z][0-9a-zA-Z_]{4,19}$/;
        var dot = 'data-original-title';

        if (login.length < 5) {
            $("#login").attr(dot,'Логин должен быть не менее 5 символов').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
        else if (login.length > 20) {
            $("#login").attr(dot,'Логин должен быть не более 20 символов').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
        else if (!expr.test(login)) {
            $("#login").attr(dot,'Логин начинается только с буквы и содержит буквы/цифры или знак подчеркивания').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
        else {
            $("#login").attr(dot,'Логин удовлетворяет условиям').tooltip('show')
                .addClass('has-success').removeClass('has-error');
        }

    };

    $scope.changePassword = function () {
        var expr = /[0-9a-zA-Z]{5,20}$/;
        var dot = 'data-original-title';

        if ($scope.user.password.length < 5) {
            $("#password").attr(dot,'Password must be more then or equal 5 characters.').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
        else if ($scope.user.password.length > 20) {
            $("#password").attr(dot,'Password must be less then or equal 20 characters.').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
        else if (!expr.test($scope.user.password)) {
            $("#password").attr(dot,'Password must have only digits or characters.').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
        else {
            $("#password").attr(dot,'Lovely password!').tooltip('show')
                .addClass('has-success').removeClass('has-error');
            if ($scope.user.repassword == $scope.user.password)
                $("#repassword").attr(dot,'Lovely repassword!').tooltip('show')
                .addClass('has-success').removeClass('has-error');
            else if ($("#repassword").hasClass('has-success')) $("#repassword").attr(dot, 'Password and repassword must be identical!').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
    };

    $scope.changeRepassword = function (repassword, password) {
        var expr = /[0-9a-zA-Z]{5,20}$/;
        var dot = 'data-original-title';
        if (repassword.length < 5) {
            $("#repassword").attr(dot,'Repassword must be more then or equal 5 characters.').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
        else if (repassword.length > 20) {
            $("#repassword").attr(dot,'Repassword must be less then or equal 20 characters.').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
        else if (!expr.test(repassword)) {
            $("#repassword").attr(dot,'Repassword must have only digits or characters.').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
        else if (repassword != password) {
            $("#repassword").attr(dot, 'Password and repassword must be identical!').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
            else {
            $("#repassword").attr(dot,'Lovely repassword!').tooltip('show')
                .addClass('has-success').removeClass('has-error');
        }
    };

    $scope.changePhone = function (phone) {
        var expr1 = /\+\d\d\s\([0-9]{3}\)\s[0-9]{3}-[0-9]{2}-[0-9]{2}$/;
        var expr2 = /[0-9]{3}\s[0-9]{3}\s[0-9]{2}\s[0-9]{2}$/;
        var expr3 = /\([0-9]{3}\)\s[0-9]{3}\s[0-9]{2}\s[0-9]{2}$/;
        var dot = 'data-original-title';

        if ((phone == '')) {
            $("#phone").removeAttr(dot).removeClass('has-success has-error');
        }
        else if ((!expr1.test(phone)) && (!expr2.test(phone)) && (!expr3.test(phone))) {
            $("#phone").attr(dot,'Телефон можно вводить в формате +38 (093) 937-99-92, 093 937 99 92, (093) 937 99 92.').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
        else {
            $("#phone").attr(dot,'OK!').tooltip('show')
                .addClass('has-success').removeClass('has-error');
        }
    };


    $scope.changeInvite = function () {
        var expr = /^\d{6}$/;
        var dot = 'data-original-title';

        if (!expr.test($scope.user.invite)) {
            $("#invite").attr(dot,'Invite field must be only 6 digits.').tooltip('show')
                .addClass('has-error').removeClass('has-success');
        }
        else {
            $("#invite").attr(dot,'Invite is valid.').tooltip('show')
                .addClass('has-success').removeClass('has-error');
        }
    };

    $http.post('myview/cities.php')
        .success(function (response) {
            $scope.countries = response.countries;
            $scope.cities = response.cities;
        })
        .error(function (response) {
            $scope.codeStatus = response || "Request failed";
        });

});

function DoPostShowTable(tablename) {
    $.post("/datarec/DBmanagement/ShowData.php", {view: tablename}, function (data) {
        $("div #MainBody").html(data);
        $("#MainBody div table thead tr th").css("text-align", "center");

    });
};



/*myApp.directive('ngTooltip', function () {
    return {
        replace: false,
        restrict:'AC',
        link:function(scope, element, attrs) {
           // element.html("name=\"work\"");
            element.attr('data-original-title','Invite field must be only 6 digits.').tooltip('show');
            element.addClass('has-error').removeClass('has-success');
        }

    }
})*/




