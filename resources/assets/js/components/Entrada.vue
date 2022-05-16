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
                        <i class="fa fa-align-justify"></i> Entradas
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <!-- Listado -->
                    <template v-if="listado==1">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="fecha_entrada">Fecha Entrada</option>
                                        <option value="nombre">Proveedor</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarEntrada(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarEntrada(1,buscar,criterio)" class="btn btn-outline-info"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-responsive table-borderless table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Opciones</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Proveedor</th>
                                        <th scope="col">Fecha_Entrada</th>
                                        <th scope="col">Total_Compra</th>
                                        <th scope="col">Condicion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="entrada in arrayEntrada" :key="entrada.id">
                                        <td>
                                            <button type="button" @click="verEntrada(entrada.id)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            <template v-if="entrada.condicion">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarEntrada(entrada.id)">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td v-text="entrada.usuario"></td>
                                        <td v-text="entrada.nombre"></td>
                                        <td v-text="entrada.fecha_entrada"></td>
                                        <td v-text="entrada.total_compra"></td>
                                        <td>
                                        <div v-if="entrada.condicion">
                                            <span class="badge badge-success">Registrada</span>
                                        </div>

                                        <div v-else>
                                            <span class="badge badge-danger">Anulada</span>
                                        </div>
                                        </td>
                                    </tr>      
                                </tbody>
                            </table>
                            </div>
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
                    </template>
                    <!-- Detalle de entrada -->
                    <template v-else-if="listado==0">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-9">  
                                    <div class="form-group">
                                        <label for="">Proveedor(*)</label>
                                        <v-select
                                            @search="selectProveedor"
                                            label="nombre"
                                            :options="arrayProveedor"
                                            placeholder="Buscar Proveedores...."
                                            @input="getDatosProveedor"
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div v-show="errorEntrada" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjEntrada" :key="error" v-text="error">
                                            </div>
                                        </div>
                                     </div>

                                </div>
                            </div>

                            <div class="form-group row border">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Producto <span style="color:red;" v-show="idproductos==0">(*Seleccione)</span> </label>
                                        <div class="form-inline">
                                            <input type="text" class="form-control" v-model="codigo" @keyup.enter="buscarProducto()" placeholder="Ingrese producto">
                                            <button @click="abrirModal()" class="btn btn-primary">....</button>
                                            <input type="text" readonly class="form-control" v-model="producto">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Precio <span style="color:red;" v-show="precio_compra==0">(*Ingrese)</span> </label>
                                        <input type="number" value="0" step="any" class="form-control" v-model="precio_compra">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Cantidad <span style="color:red;" v-show="cantidad==0">(*Ingrese)</span></label>
                                        <input type="number" value="0"  class="form-control" v-model="cantidad">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar">
                                            <i class="icon-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>


                    <div class="form-group row border">
                        <div class="table-responsive col-md-12">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>SubTotal</th>
                                    </tr>
                                </thead>
                                <tbody v-if="arrayDetalle.length">
                                    <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                        <td>
                                            <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                <i class="icon-close"></i>
                                            </button>
                                        </td>
                                        <td v-text="detalle.producto">
                                               
                                        <td>
                                            <input v-model="detalle.precio_compra" type="number" value="3" class="form-control">
                                        </td>
                                        <td>
                                            <input v-model="detalle.cantidad" type="number" value="2" class="form-control">
                                        </td>
                                        <td>${{detalle.precio_compra*detalle.cantidad}}</td>
                                    </tr>
                                    <tr style="background-color:#B0C4DE;">
                                        <td colspan="4" align="right"><strong>Total_Compra:</strong></td>
                                        <td>${{total_compra=calcularTotal}}</td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr colspan="5">
                                        <td>No hay productos agregados</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-md-12">
                            <button type="button" @click="ocultarDetalle()" class="btn btn-dark">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="registrarEntrada()" >Registrar Entrada</button>

                        </div>
                    </div>

                        </div>
                     </template>
                <!-- Fin ejemplo de tabla Listado -->
                  <template v-else-if="listado==2">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-9">  
                                    <div class="form-group">
                                        <label for=""> <strong>Proveedor()</strong> </label>
                                        <p v-text="proveedor"></p>
                                    </div>
                                </div>
                               
                            </div>
                    <div class="form-group row border">
                        <div class="table-responsive col-md-12">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>SubTotal</th>
                                    </tr>
                                </thead>
                                <tbody v-if="arrayDetalle.length">
                                    <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                        <td v-text="detalle.producto">
                                               
                                        <td v-text="detalle.precio_compra">
                                        </td>
                                        <td v-text="detalle.cantidad">
                                        </td>
                                        <td>${{detalle.precio_compra*detalle.cantidad}}</td>
                                    </tr>
                                    <tr style="background-color:	#90EE90;">
                                        <td colspan="3" align="right"><strong>Total_Compra:</strong></td>
                                        <td>${{total_compra}}</td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr colspan="5">
                                        <td>No hay productos agregados</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-md-12">
                            <button type="button" @click="ocultarDetalle()" class="btn btn-dark">Cerrar</button>
                        </div>
                    </div>

                        </div>
                     </template>
            </div>
        </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterioP">
                                        <option value="nombre">Nombre</option>
                                        <option value="descripcion">Descripción</option>
                                        <option value="codigo">codigo</option>
                                        </select>
                                        <input type="text" v-model="buscarP" @keyup.enter="listarProducto(buscarP,criterioP)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit"  @click="listarProducto(buscarP,criterioP)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>SKU</th>
                                    <th>Nombre</th>
                                    <th>Categoria</th>
                                    <th>Precio Actual</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="producto  in arrayProducto" :key="producto.id">
                                    <td>
                                        <button type="button"  @click="agregarDetalleModal(producto)" class="btn btn-success btn-sm" >
                                          <i class="icon-check"></i>
                                        </button>
                                    </td>
                                    <td v-text="producto.codigo"></td>
                                    <td v-text="producto.nombre"></td>
                                    <td v-text="producto.nombre_categoria"></td>
                                    <td v-text="producto.precio_actual"></td>
                                    <td v-text="producto.stock"></td>
                                    <td>
                                       <div v-if="producto.condicion">
                                        <span class="badge badge-success">Activo</span>
                                      </div>

                                      <div v-else>
                                        <span class="badge badge-danger">Desactivo</span>
                                      </div>
                                    </td>
                                </tr>
                            </tbody>
                             <!-- Hasta aca llega la vista de  la tabla de vistas de categorias -->

                             </table>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
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
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    export default {
        data (){
            return {
                entrada_id: 0,
                idproveedores : 0,
                proveedor:'',
                nombre : '',
                total_compra : 0.0,
                arrayEntrada : [],
                arrayDetalle : [],
                arrayProveedor : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorEntrada : 0,
                errorMostrarMsjEntrada : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'fecha_entrada',
                buscar : '',
                criterioP:'nombre',
                buscarP:'',
                arrayProducto: [],
                idproductos:0,
                codigo:'',
                producto:'',
                precio_compra:0,
                cantidad:0

            }
        },
        components:{ 
            vSelect
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

            },
            calcularTotal:function(){
                var resultado=0.0;
                for (var i = 0; i<this.arrayDetalle.length; i++) {
                   resultado=resultado+(this.arrayDetalle[i].precio_compra*this.arrayDetalle[i].cantidad)
                    
                }
                return resultado;
            }
        },
        methods : {
            listarEntrada (page,buscar,criterio){
                let me=this;
                var url= '/entrada?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEntrada = respuesta.entradas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectProveedor(search,loading){
                let me=this;
                loading(true)

                var url= '/proveedor/selectProveedor?filtro='+search;
                axios.get(url).then(function (response) {
                    let  respuesta = response.data;
                    q:search
                    me.arrayProveedor=respuesta.proveedores;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosProveedor(val1) {
                let me =this;
                me.loading = true;
                me.idproveedores = val1.id;
            },
            buscarProducto()
            { 
                let me=this;
                var url= '/producto/buscarProducto?filtro=' + me.codigo;

                axios.get(url).then(function (response){ 
                    var respuesta=response.data;
                    me.arrayProducto = respuesta.productos;

                    if (me.arrayProducto.length>0){ 
                        me.producto=me.arrayProducto[0]['nombre'];
                        me.idproductos=me.arrayProducto[0]['id'];
                    }
                    else{ 
                        me.producto="No existe producto";
                        me.idproductos=0;
                    }
                 })
                 .catch(function(error){
                     console.log(error);
                  });
            },

            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarEntrada(page,buscar,criterio);
            },
            encuentra(id){
                var sw=0;
                for (var i= 0; i<this.arrayDetalle.length; i++) {
                    if (this.arrayDetalle[i].idproductos==id) {
                        sw=true;
                    }
                 }
                return sw;
            },
            agregarDetalle(){
                let me= this;
                if(me.idproductos==0 || me.cantidad==0 || me.precio_compra==0){   
                }
                else{
                    if (me.encuentra(me.idproductos)) {
                        swal({
                            type: 'error',
                            title: 'Error.....',
                            text:'Este producto ya se encuentra agregado!',
                        })
                        
                    }
                   else{

                    me.arrayDetalle.push({
                        idproductos: me.idproductos,
                        producto: me.producto,
                        cantidad: me.cantidad,
                        precio_compra: me.precio_compra
                     });
                    me.codigo="";
                    me.idproductos=0;
                    me.producto="";
                    me.cantidad=0;
                    me.precio_compra=0;
                   }
                }
               
            },
            agregarDetalleModal(data=[]){
                let me=this;
                if (me.encuentra(data['id'])) {
                        swal({
                            type: 'error',
                            title: 'Error.....',
                            text:'Este producto ya se encuentra agregado!',
                        })
                        
                    }
                   else{

                    me.arrayDetalle.push({
                        idproductos: data['id'],
                        producto: data['nombre'],
                        cantidad: 1,
                        precio_compra: 1
                     });
                   }

            },
            listarProducto(buscar,criterio){
                let me=this;
                var url = '/producto/listarProducto?buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                  var respuesta = response.data;
                  me.arrayProducto = respuesta.productos.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },   
            registrarEntrada(){
                if (this.validarEntrada()){
                    return;
                }
                
                let me = this;

                axios.post('/entrada/registrar',{
                    'idproveedores': this.idproveedores,
                    'total_compra': this.total_compra,
                    'data': this.arrayDetalle

                }).then(function (response) {
                    me.listado=1;
                    me.listarEntrada(1,'','nombre');
                    me.idproveedores=0;
                    me.total_compra=0;
                    me.idproductos=0;
                    me.producto='';
                    me.cantidad=0;
                    me.precio_compra=0;
                    me.arrayDetalle=[];
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarEntrada(){
                this.errorEntrada=0;
                this.errorMostrarMsjEntrada =[];

                if (this.idproveedores==0) this.errorMostrarMsjEntrada.push("Seleccione un proveedor.");
                if (this.arrayDetalle.length<=0) this.errorMostrarMsjEntrada.push("Ingrese Detalles.");

                if (this.errorMostrarMsjEntrada.length) this.errorEntrada = 1;

                return this.errorEntrada;
            },
            mostrarDetalle(){
                let me=this;
                this.listado=0;

                me.idproveedores=0;
                me.total_compra=0;
                me.idproductos=0;
                me.producto='';
                me.cantidad=0;
                me.precio_compra=0;
                 me.arrayDetalle=[];

            },
             ocultarDetalle(){
                  this.listado=1;
            },
            verEntrada(id){
                let me=this;
                this.listado=2;

                //Obtener los datos del ingreso++++
                var arrayEntradaT=[];

                var url= '/entrada/obtenerCabecera?id=' + id;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayEntradaT = respuesta.entrada;

                    me.proveedor = arrayEntradaT[0]['nombre'];
                    me.total_compra = arrayEntradaT[0]['total_compra'];

                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos del detalle++++

                var url= '/entrada/obtenerDetalle?id=' + id;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;


                })
                .catch(function (error) {
                    console.log(error);
                });

               
             },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            },
            abrirModal(){
                this.arrayProducto=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios Productos';
            },
            desactivarEntrada(id){
               swal({
                title: 'Esta seguro de anular la entrada?.',
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

                    axios.put('/entrada/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEntrada(1,'','nombre');
                        swal(
                        'Anulado!',
                        'La entrada ha sido anulada con éxito.',
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
            this.listarEntrada(1,this.buscar,this.criterio);
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
    @media (min-width: 600px){
        .btnagregar{
            margin-top:2rem;
        }
    
    }
</style>
