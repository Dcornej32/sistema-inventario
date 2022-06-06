<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte mensual de productos</title>
    <style>

          body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
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
<body>
    <div>
        <h3>Lista de los  productos  por mes.<span class="derecha">{{now()}}</span></h3>
    </div>
    <div>
        
        <table class="table table-responsive table-borderless table-sm">
            <thead>
                <tr>
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
                @foreach ($productos as $a)
                    
                    <tr>
                        <td>{{$a->codigo}}</td>
                        <td>{{$a->nombre}}</td>
                        <td>{{$a->nombre_categoria}}</td>
                        <td>{{$a->precio_actual}}</td>
                        <td>{{$a->stock}}</td>
                        <td>{{$a->descripcion}}</td>
                        <td>{{$a->condicion?'Activo':'Desactivado'}}</td>
                    </tr>
                @endforeach

            </tbody>

        </table>
    </div>
    <div class="izquierda">
        <p><strong></strong></p>
    </div>
</body>
</html>