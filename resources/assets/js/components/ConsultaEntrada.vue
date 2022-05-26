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
                                            </button>&nbsp;
                                            <button type="button" @click="pdfEntrada(entrada.id)" class="btn btn-info btn-sm">
                                            <i class="icon-doc"></i>
                                            </button>
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
            pdfEntrada(id){
                window.open('/entrada/pdf/'+ id ,'_blank');
            },

            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarEntrada(page,buscar,criterio);
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

               
             }
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
