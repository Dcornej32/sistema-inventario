<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Entradas</title>
    <style>
    body {
        font-family:Georgia; 
        background-color:	#eeeeee;
        }

        .logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }
 
        img{
        width: 100px;
        }
 
 
        .datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        }
 
        .encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 18px;
        }
 
        section{
        clear: left;
        }
 

     
       
        #datosproveedor{
        text-align: left;
        font-size: 15px;
        }
 
        #proveedor{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 18px;
        }


        #proveedor thead{
        padding: 20px;
        background: 	#B0C4DE;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }
 
      
 
 
        #usuario{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }
 
        #usuario thead{
        padding: 20px;
        background:	#B0C4DE;
        text-align: center;
        margin:10px;
        border-bottom: 1px solid #FFFFFF;  
        }


        #pr, #us,#pd{
        float: center;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        }
 

 
        #producto{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }
 
        #producto thead{
        padding: 20px;
        background: 	#B0C4DE;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #usuario,#producto{
            border-style: solid;
             border-top-width: 1px;
            border-right-width: 1px;
            border-bottom-width: 1px;
            border-left-width: 1px
        }
        #color{
           background-color: 	#B0C4DE;
        }
        #usuario,th{
            text-align: center;
            vertical-align:
        }
        #producto,th{
            text-align: center;
            vertical-align:
        }
     
    </style>
   
    <body>
        @foreach ($entrada as $e)
            <header>
                <div class="logo">
                    <img src="img/logo.jpeg"  id="imagen">
                </div>
                <div class="datos">
                    <p class="encabezado">
                        <b>Nombre de la empresa:</b>
                        <br><b>Dirección de la empresa:</b>
                        <br><b>Telefono de la empresa:</b>
                        <br><b>Email de la empresa: </b>
                    </p>
                </div>
            </header>
            <section>
        <br>
        <hr><hr>
        <section>
            <div>

                <table id="proveedor">
                    <thead>                        
                        <tr>
                            <th id="pr">PROVEEDOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>
                            <p id="datosproveedor">
                                <b>Sr(a).</b>  {{$e->nombre}}<br>
                                <b>Tipo de doucumento:.</b> {{$e->tipo_documento}}<br>
                                <b>Número de documento:.</b>  {{$e->numero_documento}}<br>
                                <b>Dirección: .</b> {{$e->direccion}}<br>
                                <b>Teléfono:.</b> {{$e->telefono}}<br>
                                <b>Email:.</b> {{$e->email}}
                        </p>
                        </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        @endforeach
        <br>
        <section>
            <div>
                <table  id="usuario">
                    <thead >
                        <tr id="us">
                            <th >USUARIO</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$e->usuario}}</td>
                            <td>{{$e->fecha_entrada}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
   
        <br>
        <br>
        <br>
        <section>
            <div>
                <table  id="producto">
                    <thead>
                        <tr id="pd">
                            <th>CANTIDAD</th>
                            <th >DESCRIPCION</th>
                            <th>PRECIO UNITARIO</th>
                            <th >PRECIO TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $det)
                        <tr>
                            <td>{{$det->cantidad}}</td>
                            <td>{{$det->producto}}</td>
                            <td>${{$det->precio_compra}}</td>
                            <td>${{$det->precio_compra*$det->cantidad}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @foreach ($entrada as $v)
                        <tr>
                            <th></th>
                            <th></th>
                            <th id="color">TOTAL COMPRA</th>
                            <td id="color">$ {{$e->total_compra}}</td>
                        </tr>
                        @endforeach
                    </tfoot>
                </table>
            </div>
        </section>
        
    </body>
</html>