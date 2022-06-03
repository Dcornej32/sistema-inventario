<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Entradas por Mes</title>   
    <body>
    <style>

body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
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
        font-size: 16px;
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
                <div class="logo">
                    <img src="img/logo.jpeg"  id="imagen">
                </div>
                @foreach ($informacion as $in)
                    <div class="datos">
                        <p class="encabezado">
                        <b>Nombre de la empresa:{{$in->nombre}}</b>
                         <br><b>Dirección:{{$in->direccion}}</b>
                        <br><b>Teléfono:{{$in->telefono}}</b>
                        <br><b>Email:{{$in->email}}</b>
                        <br><b>Rubro:{{$in->giro}}</b>
                    </div>
                @endforeach
            </header>
            <section>
        <br>
        <hr><hr>
        <br>
        <section>
        <div>
        <h3>Lista de Entradas Mensuales <span class="derecha">{{now()}}</span></h3>
       </div>
            <div>
            <table class="table table-responsive table-borderless table-sm">
            <thead>
                <tr>
                    <th scope="col">Proveedor</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Email</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entrada as $a) 
                    <tr>
                        <td>{{$a->nombre}}</td>>
                        <td>{{$a->telefono}}</td>
                        <td>{{$a->email}}</td>
                        <td>{{$a->usuario}}</td>
                        <td>{{$a->fecha_entrada}}</td> 
                        <td>${{$a->total_compra}}</td> 
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
            <p><strong>Total de registros: </strong></p>
            </div>
        </section>
        
    </body>
</html>