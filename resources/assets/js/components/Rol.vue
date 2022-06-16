<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Roles
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarRol(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarRol(1,buscar,criterio)" class="btn btn-outline-info"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive table-borderless table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Opciones</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rol in arrayRol" :key="rol.id">
                                    <td>
                                        <button type="button" @click="abrirModal('rol','actualizar',rol)" class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="rol.condicion">
                                         <button type="button" class="btn btn-danger btn-sm" @click="desactivarRol(rol.id)">
                                          <i class="icon-trash"></i>
                                        </button>  
                                        </template> 
                                        <template v-else>
                                         <button type="button" class="btn btn-info btn-sm" @click="activarRol(rol.id)">
                                          <i class="icon-check"></i>
                                        </button>  
                                        </template> 
                                    </td>
                                    <td v-text="rol.nombre"></td>
                                    <td v-text="rol.descripcion"></td>
                                    <td>
                                        <div v-if="rol.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header verde">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del rol">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>

                                <div v-show="errorRol" class="form-group row div-error">
                                 <div class="text-center text-error">
                                 <div v-for="error in errorMostrarMsjRol" :key="error" v-text="error">
                                 </div>
                                 </div>
                                </div>


                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn verde" @click="registrarRol()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn verde" @click="actualizarRol()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        data (){
            return {
                rol_id: 0,
                nombre : '',
                descripcion : '',
                arrayRol : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorRol: 0,
                errorMostrarMsjRol: [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarRol (page,buscar,criterio){
                let me=this;
                var url= '/rol?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRol = respuesta.roles.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarRol(page,buscar,criterio);
            },
            registrarRol(){
                if (this.validarRol()){
                    return;

                }
                let me = this;

                axios.post('/rol/registrar',{
                  'nombre': this.nombre,
                  'descripcion': this.descripcion
                }).then(function(response){
                    me.cerrarModal();
                    me.listarRol(1,'','nombre');
                }).catch(function(error){
                    console.log(error);
                });

        },
        actualizarRol(){
            if (this.validarRol()){
                    return;

                }
                let me = this;

                axios.put('/rol/actualizar',{
                  'nombre': this.nombre,
                  'descripcion': this.descripcion,
                  'id': this.rol_id
                }).then(function(response){
                    me.cerrarModal();
                    me.listarRol(1,'','nombre');
                }).catch(function(error){
                    console.log(error);
                });

        },
        desactivarRol(id){
            swal({
            title: 'Esta seguro de desactivar este Rol?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'green',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!',
            cancelButtonText: 'Cancelar!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                let me = this;

                axios.put('/rol/desactivar',{
                  'id': id
                }).then(function(response){
                    me.listarRol(1,'','nombre');
                    swal(
                'Desactivado!',
                'El registro ha sido Desactivado con éxito.',
                'success'
                )

                }).catch(function(error){
                    console.log(error);
                });

                
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swal(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
                )
            }
            })

        },

        activarRol(id){
            swal({
            title: 'Esta seguro de activar este rol?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'green',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar!',
            cancelButtonText: 'Cancelar!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                let me = this;

                axios.put('/rol/activar',{
                  'id': id
                }).then(function(response){
                    me.listarRol(1,'','nombre');
                    swal(
                'Activado!',
                'El registro ha sido activado con éxito.',
                'success'
                )

                }).catch(function(error){
                    console.log(error);
                });

                
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swal(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
                )
            }
            })

        },

        validarRol(){
            this.errorRol=0,
            this.errorMostrarMsjRol =[];

            if (this.nombre == '' || this.nombre == null) 
            {
                this.errorMostrarMsjRol.push("El nombre del rol no puede estar vacío");
            }
            else if (!/^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/.test(this.nombre)){
                this.errorMostrarMsjRol.push("El nombre del rol no debe contener números");
            }
            else if (!/^[A-Z]/.test(this.nombre)){
                this.errorMostrarMsjRol.push("El nombre del rol debe iniciar con una letra mayúscula");
            } 
            else if (this.nombre.length<=3){
                this.errorMostrarMsjRol.push("El nombre del rol no es valido");
            } 

            if (this.errorMostrarMsjRol.length) this.errorRol = 1;
            return this.errorRol;
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.nombre='';
            this.descripcion='';


        },
        abrirModal(modelo, accion, data = []){
            switch (modelo){
                case "rol":
                {
                    switch(accion){
                        case 'registrar':
                        {
                            this.modal = 1;
                            this.tituloModal = 'Registrar Rol';
                            this.nombre = '';
                            this.descripcion = '';
                            this.tipoAccion = 1;
                            break;
                            
                        }
                        case 'actualizar':
                        {
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Actualizar Rol';
                            this.tipoAccion=2;
                            this.rol_id=data['id'];
                            this.nombre = data['nombre'];
                            this.descripcion = data['descripcion'];
                            break;

                        }
                    }
                }
            }
        }
        },
        mounted() {
            this.listarRol(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
