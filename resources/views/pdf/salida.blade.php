<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Salidas</title>
    <style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background-color:#eee;
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
        font-size: 17px;
        }
 
        section{
        clear: left;
        }
       
        #datosproveedor{
        text-align: left;
        font-size: 17px;
        }
 
        #proveedor{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 18px;
        }

        #proveedor thead{
        padding: 20px;
        background:#B0C4DE;
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
            <header>
                <div class="logo">
                <img src="img/logo.jpeg"  id="imagen">
                </div>
                @foreach ($informacion as $in)
                    <div class="datos">
                        <p class="encabezado">
                            <b>Nombre de la empresa:{{$in->nombre}}</b>
                            <br><b>Dirección:{{$in->direccion}}</b>
                            <br><b>Teléfono:{{$in->telefono}}</b>
                            <br><b>Email:{{$in->email}} </b>
                            <br><b>Rubro:{{$in->giro}}</b>
                        </p>
                    </div>
                @endforeach
            </header>
            <section>
        <br>
        <hr><hr>
        <section>
            <div>
            @foreach ($salida as $s)
                <table id="cliente">
                    <thead>                        
                        <tr>
                            <th id="cl">CLIENTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>
                            <p id="datoscliente">
                                <b>Sr(a).</b>  {{$s->nombre}}<br>
                                <b>Tipo de doucumento:</b> {{$s->tipo_documento}}<br>
                                <b>Número de documento:</b>  {{$s->numero_documento}}<br>
                                <b>Dirección:</b> {{$s->direccion}}<br>
                                <b>Teléfono:</b> {{$s->telefono}}<br>
                                <b>Email:</b> {{$s->email}}
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
                            <td>{{$s->usuario}}</td>
                            <td>{{$s->fecha_salida}}</td>
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
                            <th >DESCRIPCIÓN</th>
                            <th>PRECIO UNITARIO</th>
                            <th >PRECIO TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $det)
                        <tr>
                            <td>{{$det->cantidad}}</td>
                            <td>{{$det->producto}}</td>
                            <td>${{$det->precio_actual}}</td>
                            <td>${{$det->precio_actual*$det->cantidad}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @foreach ($salida as $d)
                        <tr>
                            <th></th>
                            <th></th>
                            <th id="color">TOTAL SALIDA</th>
                            <td id="color">$ {{$d->total}}</td>
                        </tr>
                        @endforeach
                    </tfoot>
                </table>
            </div>
        </section>
        <br><br>
        <h3>Fecha de comprobante:</h3><span>{{now()}}</span>
    </body>
</html>