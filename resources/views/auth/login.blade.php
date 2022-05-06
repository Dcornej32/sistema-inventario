@extends('auth.contenido')

@section('login')
<main id="content" class="widget-login-container" role="main">
            <!-- Page content -->
            <div class="row align-item-center">
                <div class="col-sm-5 offset-0  offset-sm-1 col-md-4  col-10 my-auto">
                    <section class="widget widget-login bg-transparent animated fadeInUp">
                        <header>
                            <h2 class="text-center">Iniciar Sesión</h2>
                        </header>
                        <div class="widget-body">
                            <p class="widget-login-info">
                                ¡Bienvenido de nuevo! Por favor, ingrese a su cuenta
                            </p>
                            <form class="login-form mt-lg">
                                <div role="group" class="form-group">
                                    <label for="email" class="d-block">Nombre de usuario</label>
                                    <div>
                                        <div role="group" class="input-group">
                                            <input id="username" type="text" value="admin" required="required" placeholder="Admin" class="form-control input-transparent pl-3">
                                        </div>
                                    </div>
                                </div>
                                <div role="group" class="form-group">
                                    <label for="password" class="d-block">Contraseña</label>
                                    <div>
                                        <div role="group" class="input-group">
                                            <input id="password" type="password" value="password" required="required" placeholder="Password" class="form-control input-transparent pl-3">
                                            <!-- <a href="#" class="btn input-group-text"><i class="fa-solid fa-key"></i></a> -->
                                            <a href="#" class="btn input-group-text"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            <!-- style="border-top: 1px solid grey; border-bottom: 1px solid grey;border-right: 1px solid grey;" -->
                                        </div>
                                    </div>
                                </div>
                                <div class="checkbox abc-checkbox mb-4 d-flex form-check">
                                    <a href="/">¿Se te olvidó tu contraseña?</a>
                                </div>
                                <div class="clearfix">
                                    <div class="btn-toolbar">
                                        <a class="btn btn-warning btn-block" href="index.html">Acceder</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </section>
                </div>
                <div class="col-sm-6 offset-0  offset-sm-1 col-md-5 col-10 my-auto">
                    <!-- <img src="... " class="rounded " alt="... "> -->
                    <img src="img/avatars/Spreadsheets.gif" class="img-fluid " alt="signin ">

                </div>

            </div>

            <footer class="page-footer ">
                
            </footer>

        </main>
@endsection
