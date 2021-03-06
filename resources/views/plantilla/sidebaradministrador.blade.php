<div class="sidebar">
            <nav class="sidebar-nav negro">
                <ul class="nav">
                    <li @click="menu=0" class="nav-item negro">
                        <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Panel Principal</a>
                    </li>
                    <li class="nav-title negro">
                        Módulos del Sistema
                    </li>
                    <li class="nav-item nav-dropdown negro borde-b">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Almacén</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=1" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Categorías</a>
                            </li>
                            <li @click="menu=2" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>   Productos</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown negro borde-b">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-note"></i> Inventario</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=3" class="nav-item">
                                <a class="nav-link" href="#"><i class=" icon-arrow-up"></i> Entradas</a>
                            </li>
                            <li @click="menu=4" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-arrow-down"></i> Salidas</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown negro borde-b">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> Personas</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=5" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user"></i> Proveedores</a>
                            </li>
                            <li @click="menu=6" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user"></i> Clientes</a>
                            </li>
                            <li @click="menu=7" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user-follow "></i> Usuarios</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown negro borde-b">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-check"></i> Acceso</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=8" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user-following"></i> Roles</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown negro borde-b">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Reportes</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=9" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> R-Entradas <span class="badge badge-danger">PDF</span></a>
                            </li>
                            <li @click="menu=10" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> R-Salidas <span class="badge badge-danger">PDF</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown negro borde-b">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-book-open"></i> Ayuda </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="window.open('http://127.0.0.1:8000/manuales/Manual_Usuario.pdf');">
                                <i class="icon-bag"></i>Manual-Usuario<span class="badge badge-danger">PDF</span></a>
                            </li>
                            <li  class="nav-item">
                                <a class="nav-link" href="#" onclick="window.open('http://127.0.0.1:8000/manuales/Manual_Almacenero.pdf');">
                                <i class="icon-bag"></i>Almacenero<span class="badge badge-danger">PDF</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item negro borde-b"  @click="menu=12">
                        <a class="nav-link" href="#"><i class="icon-info"></i> Acerca de...</a>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>