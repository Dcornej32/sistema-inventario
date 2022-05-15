<template>
     <main class="main">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Información
                        <button type="button" @click="abrirModal('informacion','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarInformacion(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarInformacion(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Núm-Tributario</th>
                                    <th>Núm-Registro</th>
                                    <th>Giro</th>
                                    <th>Contacto</th>
                                    <th>TeléfonoContacto</th>
                                    <th>Cargo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="informacion in arrayInformacion" :key="informacion.id">
                                    <td>
                                        <button type="button" @click="abrirModal('informacion','actualizar',informacion)" class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                        </button> 
                                    </td>
                                    <td v-text="informacion.nombre"></td>
                                    <td v-text="informacion.direccion"></td>
                                    <td v-text="informacion.email"></td>
                                    <td v-text="informacion.telefono"></td>
                                    <td v-text="informacion.numero_tributario"></td>
                                    <td v-text="informacion.numero_registro"></td>
                                    <td v-text="informacion.giro"></td>
                                    <td v-text="informacion.nombre_contacto"></td>
                                    <td v-text="informacion.telefono_contacto"></td>
                                    <td v-text="informacion.cargo"></td>
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
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Ingrese nombre.">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Dirección</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Ingrese la dirección">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="email" class="form-control" placeholder="Ingrese E-mail">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Teléfono</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="telefono" class="form-control" placeholder="Ingrese teléfono ">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Número Tributario</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="numero_tributario" class="form-control" placeholder="Ingrese el número tributario">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Número_registro</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="numero_registro" class="form-control" placeholder="Ingrese Número de registro">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Giro</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="giro" class="form-control" placeholder="Ingrese Giro">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre Contacto</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre_contacto" class="form-control" placeholder="Ingrese nombre del contacto.">
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Teléfono</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="telefono_contacto" class="form-control" placeholder="Ingrese teléfono del contacto">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Cargo</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="cargo" class="form-control" placeholder="Cargo que del contacto.">
                                    </div>
                                </div>

                                <div v-show="errorInformacion" class="form-group row div-error">
                                    <div class="text-center text-error">
                                     <div v-for="error in errorMostrarMsjInformacion" :key="error" v-text="error">
                                     </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                     <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn verde" @click="registrarInformacion()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn verde" @click="actualizarInformacion()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        data(){
            return{
                informacion_id: 0,
                nombre: '',
                direccion: '',
                email: '',
                telefono: '',
                numero_tributario: '',
                numero_registro: '',
                giro: '',
                nombre_contacto: '',
                telefono_contacto: '',
                cargo: '',
                arrayInformacion:[],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorInformacion: 0,
                errorMostrarMsjInformacion: [],
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

            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1){
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
        methods: {
            listarInformacion(page,buscar,criterio){
                let me=this;
                var url= '/informacion?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response){
                    var respuesta= response.data;
                    me.arrayInformacion= respuesta.informaciones.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                })
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarInformacion(page,buscar,criterio);
            },

            registrarInformacion(){
                if (this.validarInformacion()){
                    return;

                }
                let me = this;

                axios.post('/informacion/registrar',{
                  'nombre': this.nombre,
                  'direccion': this.direccion,
                  'email': this.email,
                  'telefono': this.telefono,
                  'numero_tributario': this.numero_tributario,
                  'numero_registro': this.numero_registro,
                  'giro': this.giro,
                  'nombre_contacto': this.nombre_contacto,
                  'telefono_contacto': this.telefono_contacto,
                  'cargo': this.cargo
                }).then(function(response){
                    me.cerrarModal();
                    me.listarInformacion(1, '', 'nombre');
                }).catch(function(error){
                    console.log(error);
                });

        },
        actualizarInformacion(){
            if (this.validarInformacion()){
                    return;

                }
                let me = this;

                axios.put('/informacion/actualizar',{
                  'nombre': this.nombre,
                  'direccion': this.direccion,
                  'email': this.email,
                  'telefono': this.telefono,
                  'numero_tributario': this.numero_tributario,
                  'numero_registro': this.numero_registro,
                  'giro': this.giro,
                  'nombre_contacto': this.nombre_contacto,
                  'telefono_contacto': this.telefono_contacto,
                  'cargo': this.cargo,
                  'id': this.informacion_id
                }).then(function(response){
                    me.cerrarModal();
                    me.listarInformacion(1, '', 'nombre');
                }).catch(function(error){
                    console.log(error);
                });

        },
        validarInformacion(){
            this.errorInformacion=0;
                this.errorMostrarMsjInformacion= [];
                if (!this.nombre) this.errorMostrarMsjInformacion.push("El nombre de la empresa, no puede estar vacio");
                if (!this.direccion) this.errorMostrarMsjInformacion.push("La dirección, es obligatoio de ingresar.");
                if (!this.telefono) this.errorMostrarMsjInformacion.push("El teléfono es obligatorio de ingresar.");
                if (!this.nombre_contacto) this.errorMostrarMsjInformacion.push("El nombre de contacto, no puede quedar vacio");
                if (!this.telefono_contacto) this.errorMostrarMsjInformacion.push("El teléfono del contacto no puede quedar vacio.");
                if (!this.cargo) this.errorMostrarMsjInformacion.push("El cargo es obligatorio de ingresar.");
                if (this.errorMostrarMsjInformacion.length) this.errorInformacion = 1; 
                return this.errorInformacion;
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.nombre='';
            this.direccion='';
            this.email='';
            this.telefono='';
            this.numero_tributario='';
            this.numero_registro='';
            this.giro='';
            this.nombre_contacto='';
            this.telefono_contacto='';
            this.cargo='';
            this.errorInformacion=0;
        },
        abrirModal(modelo, accion, data = []){
            switch (modelo){
                case "informacion":
                {
                    switch(accion){
                        case 'registrar':
                        {
                            this.modal = 1;
                            this.tituloModal = 'Registrar Información';
                            this.nombre='';
                            this.direccion='';
                            this.email='';
                            this.telefono='';
                            this.numero_tributario='';
                            this.numero_registro='';
                            this.giro='';
                            this.nombre_contacto='';
                            this.telefono_contacto='';
                            this.cargo='';
                            this.tipoAccion = 1;
                            break;
                            
                        }
                        case 'actualizar':
                        {
                            this.modal=1;
                            this.tituloModal='Actualizar La Información';
                            this.tipoAccion=2;
                            this.informacion_id=data['id'];
                            this.nombre = data['nombre'];
                            this.direccion= data['direccion'];
                            this.email= data ['email'];
                            this.telefono= data ['telefono'];
                            this.numero_tributario= data ['numero_tributario'];
                            this.numero_registro= data ['numero_registro'];
                            this.giro= data ['giro'];
                            this.nombre_contacto= data ['nombre_contacto'];
                            this.telefono_contacto= data ['telefono_contacto'];
                            this.cargo= data ['cargo'];
                            break;
                        }
                    }
                }
            }
        }
    },

        mounted() {
            this.listarInformacion(1,this.buscar,this.criterio);
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