<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Salidas por Dia</title>   
    <body>
    <style>

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;   
            font-size: 16px;        
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
        margin-right: 30%;
        }

        section{
        clear: left;
        }
 
 
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }

    </style>
</head>
      
            <header>
                
                @foreach ($informacion as $in)
                <div class="datos">
                    <p class="encabezado">
                        <b>Nombre de la empresa:{{$in->nombre}}</b>
                        <br><b>Dirección:{{$in->direccion}}</b>
                        <br><b>Teléfono:{{$in->telefono}}</b>
                        <br><b>Email:{{$in->email}} </b>
                        <br><b>Rubro:{{$in->giro}} </b>
                    </p>
                </div>
                @endforeach
            </header>
            <section>
        <br>
        <hr><hr>
        <br>
        <section>
        <div>
        <h4>Lista de Salidas Por Día <span class="derecha">{{now()}}</span></h4>
       </div>
            <div>
            <table class="table table-responsive table-borderless table-sm">
            <thead>
                <tr>
                    <th scope="col">Cliente</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Email</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salida as $s)
                    
                    <tr>
                        <td>{{$s->nombre}}</td>>
                        <td>{{$s->telefono}}</td>
                        <td>{{$s->email}}</td>
                        <td>{{$s->usuario}}</td>
                        <td>{{$s->fecha_salida}}</td> 
                        <td>${{$s->total}}</td> 

                    </tr>
                @endforeach
            </tbody>

        </table>
            </div>
        </section>
   
        <br>
        <br>
        <br>
        <section>
            <div>
              
            </div>
        </section>
        
    </body>
</html>