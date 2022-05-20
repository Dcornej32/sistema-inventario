<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Salidas</title>
    <style>
    body {
        font-family:Verdana, Geneva, Tahoma, sans-serif; 
        background-color:#F0FFF0;
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
 

     
       
        #datoscliente{
        text-align: left;
        font-size: 15px;
        }
 
        #cliente{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 18px;
        }


        #cliente thead{
        padding: 20px;
        background: #95c799;
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
        background: #95c799;
        text-align: center;
        margin:10px;
        border-bottom: 1px solid #FFFFFF;  
        }


        #cl, #us,#pd{
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
        background: #95c799;
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
           background-color: #b8daba;
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
        @foreach ($salida as $s)
            <header>
                <div class="logo">
                    <img src="">
                </div>
                <div class="datos">
                    <p class="encabezado">
                        <b> <i>Nombre de la empresa:</i></b>
                        <br><b><i>Dirección de la empresa:</i></b>
                        <br><b><i>Telefono de la empresa:</i></b>
                        <br><b><i>Email de la empresa: </i></b>
                    </p>
                </div>
            </header>
            <section>
        <br>
        <hr><hr>
        <section>
            <div>

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
                                <b>Tipo de doucumento:.</b> {{$s->tipo_documento}}<br>
                                <b>Número de documento:.</b>  {{$s->numero_documento}}<br>
                                <b>Dirección: .</b> {{$s->direccion}}<br>
                                <b>Teléfono:.</b> {{$s->telefono}}<br>
                                <b>Email:.</b> {{$s->email}}
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
        
    </body>
</html>