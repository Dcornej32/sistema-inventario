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
                        <i class="fa fa-align-justify"></i> Productos
                        <button type="button"  @click="abrirModal('producto','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button type="button"  @click="cargarPdf()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button>

                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarProducto(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit"  @click="listarProducto(1,buscar,criterio)" class="btn btn-outline-info"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-responsive table-borderless table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Opciones</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Precio Actual</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                             <!-- Hasta aca empieza la vista de  la tabla de vistas de categorias -->

                                <tr v-for="producto  in arrayProducto" :key="producto.id">
                                    <td>
                                        <button type="button"  @click="abrirModal('producto','actualizar',producto)" class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="producto.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarProducto(producto.id)" >
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>

                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarProducto(producto.id)" >
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="producto.codigo"></td>
                                    <td v-text="producto.nombre"></td>
                                    <td v-text="producto.nombre_categoria"></td>
                                    <td v-text="producto.precio_actual"></td>
                                    <td v-text="producto.stock"></td>
                                    <td v-text="producto.descripcion"></td>
                                   

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
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page -1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>

                                <li class="page-item"  v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <!--Borrramos el id del modal-->

            <div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true" :class="{'mostrar': modal}">
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
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                        <div>
                                            <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del Producto">
                                            <!-- Se eliminar la siguiente linea de codigo -->
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                                        <div>
                                            <textarea type="text" v-model="descripcion" class="form-control" placeholder="Ingrese la descripcion">
                                            <!-- Se eliminar la siguiente linea de codigo -->
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                             <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="col-md-6 form-control-label" for="text-input">Precio Actual</label>
                                    <div>
                                        <input type="number" v-model="precio_actual"  class="form-control" placeholder="Precio '10.99'">
                                         <!-- Se eliminar la siguiente linea de codigo -->
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="col-md-3 form-control-label" for="text-input">stock</label>
                                    <div>
                                        <input type="number" v-model="stock" class="form-control" placeholder="Stock '100'">
                                         <!-- Se eliminar la siguiente linea de codigo -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="col-md-3 form-control-label" for="text-input">SKU</label>
                                    <div>
                                        <input type="text" v-model="codigo" class="form-control" placeholder="Codigo 'sv000000'">
                                        <barcode :value="codigo" :options="{ format: 'EAN-13' }"> </barcode>
                                        Generando un código
                                         <!-- Se eliminar la siguiente linea de codigo -->
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-md-3 form-control-label" for="text-input">Categorías</label>
                                    <div>
                                        <select class="form-control" v-model="idcategorias" > 
                                            <option value="0" disabled> Seleccione </option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"> 
                                            </option>
                                        </select>
                                            <!-- Se eliminar la siguiente linea de codigo -->
                                    </div>
                                </div>
                            </div>
                            


                            <div v-show="errorProducto" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error">
                                        </div>
                                    </div>
                            </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                              <!-- Se agregar el tipo de acciòn que realizara cada boton -->
                            <button type="button" class="btn btn-primary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn verde rounded-pill" @click="registrarProducto()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn verde" @click="actualizarProducto()">Actualizar</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!-- Inicio del modal Eliminar -->
           
        </main>
</template>

<script>
    import VueBarcode from 'vue-barcode';

    export default {
        data(){
            return{
                producto_id:0,
                nombre_categoria:'',
                codigo:'',
                nombre:'',
                precio_actual:'',
                stock:0,
                descripcion:'',
                idcategorias:0,
                //arreglo para almacenar todos los datos de la tabla
                arrayProducto:[],
                //para controlar si muestra o no la ventana del modelo
                modal:0,
                //para cambiar el titulo del modal
                tituloModal:'',
                tipoAccion:0,
                errorProducto:0,
                errorMostrarMsjProducto:[],
                pagination:{
                    'total': 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from': 0,
                    'to': 0
                 },
                 offset: 3,
                 //para la busqueda
                 criterio: 'nombre',
                 buscar: '',
                 arrayCategoria : []
            }
        },
        components: {
        'barcode': VueBarcode
     },

        computed:{
        isActived: function(){
         return this.pagination.current_page;
        },

        pagesNumber: function() {
             if (!this.pagination.to) {
             return [];
             }

             var from = this.pagination.current_page - this.offset;
             if (from < 1) {
                 from = 1;
                 
            }

            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                 to = this.pagination.last_page;
            }

            var pagesArray = [];
                while (from <= to) {
                pagesArray.push(from);
                from++;
            }

            return  pagesArray;
            }

        },


        methods:{

        //PARA LISTAR TODAS LAS CATEGORIAS
            listarProducto(page,buscar,criterio){
                let me=this;
                var url = '/producto?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
              // obtener los  valores del request /categoria está guardado en las rutas
              axios.get(url).then(function (response) {
                  var respuesta = response.data;
                  me.arrayProducto = respuesta.productos.data;
                  me.pagination = respuesta.pagination;
                // handle success
               // Comentamos esta linea
               // console.log(response);  
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },

            //Metodo para cargar el pdf
            cargarPdf(){
                window.open('http://127.0.0.1:8000/producto/listarPdf', '_blank');
            },


        //Metodo ṕara listar todos los registros de la tabla
             selectCategoria(){
                let me=this;
                //la pagina que deseamos listar
                var url = '/categoria/selectCategoria';
              // obtener los  valores del request /categoria está guardado en las rutas
               axios.get(url).then(function (response) {
                  //console.log(response);
                    var respuesta = response.data;
                    me.arrayCategoria = respuesta.categorias;  
                })
                .catch(function (error) {
                    console.log(error);
                })
            },

        //Metodo para cambiar la pagina
        cambiarPagina(page,buscar,criterio){
            let me = this;
            me.pagination.current_page = page;
            me.listarProducto(page,buscar,criterio);
        },


        //PARA GUARDAR LOS REGISTROS DE CATEGORIA EN LA TABLA
        registrarProducto(){
                if (this.validarProducto()) {
                    return;
                }

                let me = this;
                   axios.post('/producto/registrar',{
                       'codigo':this.codigo,
                       'nombre':this.nombre,
                       'stock':this.stock,
                       'precio_actual':this.precio_actual,
                       'descripcion': this.descripcion, 
                       'idcategorias':this.idcategorias,
                }).then(function (response){
                   me.cerrarModal();
                   me.listarProducto(1,'','nombre');
              }).catch(function (error){
                console.log(error);
            });
        },

        //ACTUALIZAR REGISTROS
         actualizarProducto(){

               if (this.validarProducto()) {
                    return;
                }

                let me = this;
                   axios.put('/producto/actualizar',{
                    'codigo':this.codigo,
                    'nombre':this.nombre,
                    'precio_actual':this.precio_actual,
                    'stock':this.stock,
                    'descripcion': this.descripcion,
                    'idcategorias':this.idcategorias,
                    'id':this.producto_id
                }).then(function (response){
                   me.cerrarModal();
                   me.listarProducto(1,'','nombre');
              }).catch(function (error){
                console.log(error);
            });
                
        },

          activarProducto(id){
            swal({
            title: 'Esta seguro de activar este producto?',
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

                axios.put('/producto/activar',{
                  'id': id
                }).then(function(response){
                    me.listarProducto(1,'','nombre');
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
        
        desactivarProducto(id){
            swal({
            title: 'Esta seguro de  desactivar este producto?',
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

                axios.put('/producto/desactivar',{
                  'id': id
                }).then(function(response){
                    me.listarProducto(1,'','nombre');
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

    

        // METODO DE VALIDAR 
            validarProducto(){
                this.errorProducto=0;
                this.errorMostrarMsjProducto= [];

                if (this.idcategorias==0) this.errorMostrarMsjProducto.push("Seleccione una categoria.");
                if (!this.nombre) this.errorMostrarMsjProducto.push("El nombre del producto, no puede estar vacio.");
                if (!this.stock) this.errorMostrarMsjProducto.push("El stock del producto debe ser un numero y no puede estar vacio.");
                if (!this.precio_actual) this.errorMostrarMsjProducto.push("El precio del producto, debe ser un numero y no puede estar vacio.");

                if (this.errorMostrarMsjProducto.length) this.errorProducto = 1; 

                return this.errorProducto;
            },

        //CERRAR EL MODAL
            cerrarModal(){
                this.modal=0;
                this.tituloModal = '';
                this.nombre_categoria= '';
                this.codigo='';
                this.nombre='';
                this.precio_actual= 0;
                this.stock= 0;
                this.descripcion = '';
                this.errorProducto= 0;
            },

        //MODELO QUE USA, REGISTRAR O ACTUALIZAR , OBJETO CON LOS DATOS DEL REGISTRO
            abrirModal(modelo, accion, data =[]){
                switch(modelo){
                    case "producto":
                    {
                        switch(accion){
                            case 'registrar':
                          {
                            this.modal = 1;
                            this.tituloModal = 'Registrar Producto';
                            this.nombre_categoria = '';
                            this.codigo = '';
                            this.nombre = '';
                            this.precio_actual = 0;
                            this.stock = 0;
                            this.descripcion = '';
                            this.idcategorias = 0;
                            this.tipoAccion = 1;
                            break; 
                         }

                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal="Actualizar Producto";
                                this.tipoAccion=2;
                                this.producto_id=data['id'];
                                this.codigo = data ['codigo'];
                                this.nombre =  data ['nombre'];
                                this.stock = data ['stock'];
                                this.precio_actual =data  ['precio_actual'];
                                this.descripcion = data ['descripcion'];
                                this.idcategorias= data ['idcategorias'];
                              break;
                            }
                        }
                     }
                }
                this.selectCategoria();
            }
       },
       mounted(){
           //usamos el metodo para listar las categorias.
            this.listarProducto(1,this.buscar,this.criterio);
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
        color: rgb(243, 56, 35) !important;
        font-weight: bold;
    }

</style>