
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
                        <i class="fa fa-align-justify"></i> Salida
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
                                        <option value="fecha_salida">Fecha Salida</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarSalida(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarSalida(1,buscar,criterio)" class="btn btn-outline-info"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-responsive table-borderless table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Opciones</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Fecha Salida</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Condición</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="salida in arraySalida" :key="salida.id">
                                        <td>
                                            <button type="button" @click="verSalida(salida.id)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            <button type="button" @click="pdfSalida(salida.id)" class="btn btn-info btn-sm">
                                            <i class="icon-doc"></i>
                                            </button> &nbsp;
                                            <template v-if="salida.condicion">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarSalida(salida.id)">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td v-text="salida.usuario"></td>
                                        <td v-text="salida.nombre"></td>
                                        <td v-text="salida.fecha_salida"></td>
                                        <td v-text="salida.total"></td>
                                        <td>
                                        <div v-if="salida.condicion">
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
                    <!-- Detalle de salida -->
                    <template v-else-if="listado==0">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-9">  
                                    <div class="form-group">
                                        <label for="">Cliente(*)</label>
                                        <v-select
                                            @search="selectCliente"
                                            label="nombre"
                                            :options="arrayCliente"
                                            placeholder="Buscar Clientes...."
                                            @input="getDatosClientes"
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div v-show="errorSalida" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjSalida" :key="error" v-text="error">
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
                                        <label for="">Precio <span style="color:red;" v-show="precio_actual==0">(*Ingrese)</span> </label>
                                        <input type="number" value="0" step="any" class="form-control" v-model="precio_actual">
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
                                        <th>Precio </th>
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
                                            <input v-model="detalle.precio_actual" type="number"  class="form-control">
                                        </td>
                                        <td>
                                            <span style="color:red;" v-show="detalle.cantidad>detalle.stock">Stock: {{detalle.stock}}</span>
                                            <input v-model="detalle.cantidad" type="number"  class="form-control">
                                        </td>
                                        <td>${{detalle.precio_actual*detalle.cantidad}}</td>
                                    </tr>
                                    <tr style="background-color:#B0C4DE;">
                                        <td colspan="4" align="right"><strong>Total:</strong></td>
                                        <td>${{total=calcularTotal}}</td>
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
                            <button type="button" class="btn btn-primary" @click="registrarSalida()" >Registrar Salida</button>

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
                                        <label for=""> <strong>Cliente()</strong> </label>
                                        <p v-text="cliente"></p>
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
                                               
                                        <td v-text="detalle.precio_actual">
                                        </td>
                                        <td v-text="detalle.cantidad">
                                        </td>
                                        <td>${{detalle.precio_actual*detalle.cantidad}}</td>
                                    </tr>
                                    <tr style="background-color:	#90EE90;">
                                        <td colspan="3" align="right"><strong>Total:</strong></td>
                                        <td>${{total=calcularTotal}}</td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr colspan="6">
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
                        <div class="modal-header verde">
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
                            <button type="button" class="btn btn-dark" @click="cerrarModal()">Cerrar</button>
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
                salida_id: 0,
                idclientes : 0,
                cliente:'',
                total_salida:0.0,
                arraySalida : [],
                arrayDetalle : [],
                arrayCliente : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorSalida : 0,
                errorMostrarMsjSalida : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'fecha_salida',
                buscar : '',
                criterioP:'nombre',
                buscarP:'',
                arrayProducto: [],
                idproductos:0,
                codigo:'',
                producto:'',
                precio_actual:0,
                cantidad:0,
                stock:0
                

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
                   resultado=resultado+(this.arrayDetalle[i].precio_actual*this.arrayDetalle[i].cantidad)
                    
                }
                return resultado;
            }
        },
        methods : {
            listarSalida (page,buscar,criterio){
                let me=this;
                var url= 'salida/?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySalida = respuesta.salidas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            pdfSalida(id){
                window.open('/salida/pdf/'+ id ,'_blank');
            },
            selectCliente(search,loading){
                let me=this;
                loading(true)

                var url= '/cliente/selectCliente?filtro='+search;
                axios.get(url).then(function (response) {
                    let  respuesta = response.data;
                    q:search
                    me.arrayCliente=respuesta.clientes;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosClientes(val1) {
                let me =this;
                me.loading = true;
                me.idclientes = val1.id;
            },
            buscarProducto()
            { 
                let me=this;
                var url= '/producto/buscarProductoSalida?filtro=' + me.codigo;

                axios.get(url).then(function (response){ 
                    var respuesta=response.data;
                    me.arrayProducto = respuesta.productos;

                    if (me.arrayProducto.length>0){ 
                        me.producto=me.arrayProducto[0]['nombre'];
                        me.idproductos=me.arrayProducto[0]['id'];
                        me.precio_actual=me.arrayProducto[0]['precio_actual'];
                        me.stock=me.arrayProducto[0]['stock'];
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
                me.listarSalida(page,buscar,criterio);
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
                if(me.idproductos==0 || me.cantidad==0 || me.precio_actual==0){   
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
                       if (me.cantidad>me.stock) {
                           swal({
                            type: 'error',
                            title: 'Error.....',
                            text:'No hay Stock disponible!',
                        })
                       }
                       else{
                        me.arrayDetalle.push({
                            idproductos: me.idproductos,
                            producto: me.producto,
                            cantidad: me.cantidad,
                            precio_actual: me.precio_actual,
                            stock: me.stock
                        });
                        me.codigo="";
                        me.idproductos=0;
                        me.producto="";
                        me.cantidad=0;
                        me.precio_actual=0;
                        me.stock=0
                       }

                 
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
                        precio_actual: data['precio_actual'],
                        stock:data['stock']
                     });
                   }

            },
            listarProducto(buscar,criterio){
                let me=this;
                var url = '/producto/listarProductoSalida?buscar=' + buscar + '&criterio=' + criterio;
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
            registrarSalida(){
                if (this.validarSalida()){
                    return;
                }
                
                let me = this;

                axios.post('/salida/registrar',{
                    'idclientes': this.idclientes,
                    'total': this.total,
                    'data': this.arrayDetalle

                }).then(function (response) {
                    me.listado=1;
                    me.listarSalida(1,'','nombre');
                    me.idclientes=0;
                    me.total=0;
                    me.idproductos=0;
                    me.producto='';
                    me.cantidad=0;
                    me.precio_actual=0;
                    me.stock=0;
                    me.codigo='';
                    me.arrayDetalle=[];
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarSalida(){
                let me=this;
                me.errorSalida=0;
                me.errorMostrarMsjSalida =[];

                var art;
                
                me.arrayDetalle.map(function(x){
                    if (x.cantidad>x.stock){
                        art=x.producto + " con stock insuficiente";
                        me.errorMostrarMsjSalida.push(art);
                    }
                });

                if (me.idclientes==0) me.errorMostrarMsjSalida.push("Seleccione un Cliente.");
                if (me.arrayDetalle.length<=0) me.errorMostrarMsjSalida.push("Ingrese Detalles.");

                if (me.errorMostrarMsjSalida.length) me.errorSalida = 1;

                return me.errorSalida;
            },
            mostrarDetalle(){
                let me=this;
                this.listado=0;

                me.idclientes=0;
                me.total=0;
                me.idproductos=0;
                me.producto='';
                me.cantidad=0;
                me.precio_actual=0;
                me.arrayDetalle=[];

            },
             ocultarDetalle(){
                  this.listado=1;
            },
            verSalida(id){
                let me=this;
                this.listado=2;

                //Obtener los datos de salida++++
                var arraySalidaT=[];

                var url= '/salida/obtenerCabecera?id=' + id;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arraySalidaT = respuesta.salida;

                    me.cliente = arraySalidaT[0]['nombre'];
                    me.total = arraySalidaT[0]['total'];

                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos del detalle++++

                var url= '/salida/obtenerDetalle?id=' + id;

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
            desactivarSalida(id){
               swal({
                title: 'Esta seguro de anular la salida?.',
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

                    axios.put('/salida/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarSalida(1,'','nombre');
                        swal(
                        'Anulado!',
                        'La salida ha sido anulada con éxito.',
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
            this.listarSalida(1,this.buscar,this.criterio);
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
