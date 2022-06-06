
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
                        <i class="fa fa-align-justify"></i> Salidas de prodcutos.
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
                                        <th scope="col">PDF</th>
                                        <th scope="col">Día</th>
                                        <th scope="col">Mes</th>
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
                                            
                                            <button type="button" @click="pdfSalida(salida.id)" class="btn btn-info btn-sm">
                                            <i class="icon-doc"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" @click="cargarPdf_Dia()" class="btn btn-secondary btn-sm">
                                            <i class="icon-doc"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" @click="cargarPdf_Mes()" class="btn btn-success btn-sm">
                                            <i class="icon-doc"></i>
                                            </button>
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
             cargarPdf_Mes(){
                window.open('/salida/MesPdf/');
            },
            cargarPdf_Dia(){
                window.open('/salida/DiaPdf/');
            },
         
       

            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarSalida(page,buscar,criterio);
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

               
             }
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
