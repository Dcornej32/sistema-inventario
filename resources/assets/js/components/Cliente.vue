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
                        <i class="fa fa-align-justify"></i> Clientes
                        <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="numero_documento">Num Documento</option>
                                      <option value="tipo_documento">Tipo Documento</option>
                                      <option value="email">Email</option>
                                      <option value="telefono">Teléfono</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-outline-info"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive table-borderless table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Opciones</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Tipo Documento</th>
                                    <th scope="col">Número</th>
                                    <th scope="col">Dirección</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td>
                                        <button type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="persona.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarCliente(persona.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarCliente(persona.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="persona.nombre"></td>
                                    <td v-text="persona.tipo_documento"></td>
                                    <td v-text="persona.numero_documento"></td>
                                    <td v-text="persona.direccion"></td>
                                    <td v-text="persona.telefono"></td>
                                    <td v-text="persona.email"></td>
                                    <td> 
                                        <div v-if="persona.condicion">
                                        <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else><span class="badge badge-danger">Inactivo</span>
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
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre<span style="color:red;">(*Ingrese)</span></label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Ej. Juan Pérez">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo Documento</label>
                                    <div class="col-md-9">
                                        <select v-model="tipo_documento" class="form-control">
                                        <option value=''>Seleccione</option>
                                        <option value="DUI">DUI</option>
                                        <option value="NIT">NIT</option>
                                        <option value="PASS">PASAPORTE</option>
                                        </select>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Número Documento</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="numero_documento" class="form-control" placeholder="Ej. 000000000">
                                    </div>
                                </div> <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Dirección</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Ej. Calle La Mascota 923b, San Salvador, El Salvador">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Teléfono</label>
                                    <div class="col-md-9">
                                        <input type="tel" v-model="telefono" class="form-control" maxlength="8" placeholder="Ej. 22223333 ó 77778888">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="name@example.com">
                                    </div>
                                </div>

                                <div v-show="errorPersona" class="form-group row div-error">
                                 <div class="text-center text-error">
                                 <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">
                                 </div>
                                 </div>
                                </div>


                            </form>
                        </div>
                        <div class="modal-footer">
                            <p>Si seleciona tipo de documento, es obligatorio que ingrese el Número de Documento.</p>
                            <button type="button" class="btn btn-dark" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn verde" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn verde" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!-- Inicio del modal Eliminar -->
            
            <!-- Fin del modal Eliminar -->
            
        </main>
</template>

<script>
    export default {
        data(){
            return{
                persona_id: 0,
                nombre: '',
                tipo_documento: 'DUI',
                numero_documento: '',
                direccion: '',
                telefono: '',
                email: '',
                arrayPersona:[],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorPersona: 0,
                errorMostrarMsjPersona: [],
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
            //listar persona
            listarPersona(page,buscar,criterio){
                let me=this;
                var url= '/cliente?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response){
                    var respuesta= response.data;
                    //handle sucess
                    me.arrayPersona= respuesta.personas.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error){
                    //handle error
                    console.log(error);
                })
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarPersona(page,buscar,criterio);


            },

            registrarPersona(){
                if (this.validarPersona()){
                    return;

                }
                let me = this;

                axios.post('/cliente/registrar',{
                  'nombre': this.nombre,
                  'tipo_documento': this.tipo_documento,
                  'numero_documento': this.numero_documento,
                  'direccion': this.direccion,
                  'telefono': this.telefono,
                  'email': this.email
                }).then(function(response){
                    me.cerrarModal();
                    me.listarPersona(1, '', 'nombre');
                }).catch(function(error){
                    console.log(error);
                });

        },
        actualizarPersona(){
            if (this.validarPersona()){
                    return;

                }
                let me = this;

                axios.put('/cliente/actualizar',{
                  'nombre': this.nombre,
                  'tipo_documento': this.tipo_documento,
                  'numero_documento': this.numero_documento,
                  'direccion': this.direccion,
                  'telefono': this.telefono,
                  'email': this.email,
                  'id': this.persona_id
                }).then(function(response){
                    me.cerrarModal();
                    me.listarPersona(1, '', 'nombre');
                }).catch(function(error){
                    console.log(error);
                });

        },
        validarPersona(){
            this.errorPersona=0,
            this.errorMostrarMsjPersona =[];

            if (this.nombre == '' || this.nombre == null) 
            {
                this.errorMostrarMsjPersona.push("El nombre del cliente no puede estar vacío, ej. Juan Pérez");
            }
            else if (!/^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/.test(this.nombre)){
                this.errorMostrarMsjPersona.push("El nombre del cliente no debe contener números");
            }
            else if (!/^[A-Z]/.test(this.nombre)){
                this.errorMostrarMsjPersona.push("El nombre del cliente debe iniciar con una letra mayúscula");
            } 
            else if (this.nombre.length<=3){
                this.errorMostrarMsjPersona.push("El nombre del cliente no es valido");
            }
            else if (!this.validTelefono(this.telefono)) {
                this.errorMostrarMsjPersona.push("Ingresa un número de teléfono valido, Ej. 22223333 ó 77778888");
            }
            else if (!this.validEmail(this.email)) {
                this.errorMostrarMsjPersona.push("Ingrese un Email valido, ej. name@example.com");
            }

            else if (!this.numero_documento == '') 
            {
                if (!/^[0-9]+$/.test(this.numero_documento)){
                    this.errorMostrarMsjPersona.push("El número de documento del cliente no debe contener letras.");
                }
                else if (this.numero_documento.length<=7){
                    this.errorMostrarMsjPersona.push("El número de documento del cliente no es valido");
                }
                
            }

           

            

            if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;
            return this.errorPersona;
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.nombre='';
            this.tipo_documento='';
            this.numero_documento='';
            this.direccion='';
            this.telefono='';
            this.email='';
            this.errorPersona=0;

        },
        validEmail (email) {
            if (!this.email == ''){
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
   
            }else{
                return true;
            }
       
        },
        validTelefono (telefono) {
            if (!this.telefono == ''){
               var  re = /^\d{8}$/;
                return re.test(telefono);
   
            }
            else{
                return true;
            }
       
        },
        abrirModal(modelo, accion, data = []){
            switch (modelo){
                case "persona":
                {
                    switch(accion){
                        case 'registrar':
                        {
                            this.modal = 1;
                            this.tituloModal = 'Registrar Cliente';
                            this.nombre='';
                            this.tipo_documento='';
                            this.numero_documento='';
                            this.direccion='';
                            this.telefono='';
                            this.email='';
                            this.tipoAccion = 1;
                            break;
                            
                        }
                        case 'actualizar':
                        {
                            //console.log(data);
                            this.modal=1;
                            this.tituloModal='Actualizar Cliente';
                            this.tipoAccion=2;
                            this.persona_id=data['id'];
                            this.nombre = data['nombre'];
                            this.tipo_documento= data['tipo_documento'];
                            this.numero_documento= data ['numero_documento'];
                            this.direccion= data ['direccion'];
                            this.telefono= data ['telefono'];
                            this.email= data ['email'];
                            break;

                        }
                    }
                }
            }
        },
            desactivarCliente(id){
               swal({
                title: 'Esta seguro de desactivar este cliente?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/cliente/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarCliente(id){
               swal({
                title: 'Esta seguro de activar este cliente?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/cliente/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
        

    },

        mounted() {
            this.listarPersona(1,this.buscar,this.criterio);
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