<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Ticket de Compra</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
    }

    h3 {
      font-size: 18px;
      text-transform: uppercase;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
    }

    .table th,
    .table td {
      padding: 5px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .total {
      text-align: right;
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="header">
    <h3> {{$planta['plan_razon_social']}} </h3>

    <h4> {{$planta['plan_ruc']}} </h4>
    ____________________________________________
    <h4>Ticket de Pago {{$pago['pago_numero']}} </h4>
    <p>Fecha: {{ $pago['pago_fecha'] }}</p>
  </div>

  <table class="table">
    <tr>
      <th>Compra</th>
      <th>Fecha</th>
      <th>Sub Total</th>
    </tr>
    @foreach($detalle as $det)
    <tr>
      <td>{{ $det['comp_serie'] }} {{ $det['comp_numero'] }}</td>
      <td>{{ $det['comp_fecha'] }}</td>
      <td>{{ $det['comp_total'] }}</td>
    </tr>
    @endforeach
  </table>

  <div class="total">
    <strong>Total: {{ $pago['pago_monto'] }}</strong>
  </div>
</body>

</html>