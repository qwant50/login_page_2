<?php
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html ng-app="myApp">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- Bootstrap -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js"></script>
    <script src="/datarec/script.js"></script>

</head>

<body>

<div class="container" ng-controller="MyCtrl">

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form class="form-horizontal novalidate" name="myForm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Registration</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label col-xs-3">Login:</label>

                            <div class="col-xs-8 input-group" id="login">
                                <input class="form-control " type="text"
                                       data-toggle="tooltip" data-placement="top"
                                       placeholder="Enter login"
                                       ng-change="changeLogin(user.login)"
                                       ng-model="user.login" required autofocus>
                                <span class="input-group-addon"><span
                                        class="glyphicon glyphicon-asterisk"></span></span>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3">Password:</label>

                            <div class="col-xs-8  input-group" id="password">
                                <input class="form-control" type="password"
                                       placeholder="Enter password"
                                       ng-change="changePassword()"
                                       ng-model="user.password" required/>
                                <span class="input-group-addon"><span
                                        class="glyphicon glyphicon-asterisk"></span></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Re password:</label>

                            <div class="col-xs-8 input-group" id="repassword">
                                <input class="form-control" type="password"
                                       placeholder="Reenter password"
                                       ng-change="changeRepassword(user.repassword,user.password)"
                                       ng-model="user.repassword" required/>
                                <span class="input-group-addon"><span
                                        class="glyphicon glyphicon-asterisk"></span></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3">Phone:</label>

                            <div class="col-xs-8 input-group" id="phone">
                                <input class="form-control" type="text"
                                       ng-change="changePhone(user.phone)"
                                       placeholder="Phone" ng-model="user.phone"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3">Country:</label>

                            <div class="col-xs-8 input-group">
                                <select class="form-control" placeholder="Country"
                                        ng-model="user.SelectedCountry"
                                        ng-options="country.country_name for country in countries">
                                    <option value="">
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">City:</label>

                            <div class="col-xs-8 input-group">
                                <select class="form-control" placeholder="City"
                                        ng-model="user.SelectedCity"
                                        ng-disabled="!user.SelectedCountry.country_name"
                                        ng-options="city.city_name for city in cities | filter: {id_country:user.SelectedCountry.id_country} track by city.id_city">
                                    <option value="">
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-3">Invite:</label>

                            <div class="col-xs-8 input-group" id="invite">
                                <input class="form-control" type="text"
                                       placeholder="Invite"
                                       ng-change="changeInvite()"
                                       ng-model="user.invite" required/>
                                <span class="input-group-addon"><span
                                        class="glyphicon glyphicon-asterisk"></span></span>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" id="submit" value="Регистрация"
                               ng-click="submit(user)"
                               ng-disabled="isFormValid()"
                            />
                        <button type="reset" class="btn btn-default" data="modal" ng-click="resetForm()">Отчистить
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- end modal form -->

    <!--  main body -->
    <div class="row">
        <div class="col-xs-12">
            <!-- nav bar  -->
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.php">Form task</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <!-- Link modal -->
                            <li><a data-toggle="modal" href="#myModal">Register a new user</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">DB View <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="index.php?view=countries">Show countries</a></li>
                                    <li><a href="index.php?view=cities">Show cities</a></li>
                                    <li><a href="index.php?view=invites">Show invites</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="index.php?view=users">Show registered users</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">DB Model <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="index.php?create">DB initialize</a></li>
                                    <li><a href="#">---</a></li>
                                    <li><a href="#">---</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">---</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>

        </div>
    </div>

    <div id="controller">
        <?php
        if (isset($_GET['create'])) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/datarec/DBmanagement/DBcreate.php';
        }
        if (isset($_GET['view'])) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/datarec/DBmanagement/ShowData.php';
        }
        ?>
    </div>



    {{getFullName()}}
</div>

</body>
</html>

