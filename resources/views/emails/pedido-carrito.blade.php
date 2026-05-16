<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pedido</title>
</head>

<body style="font-family: Arial; background:#f3f4f6; padding:20px;">

    <div style="max-width:650px; margin:auto; background:white; border-radius:12px; padding:24px; box-shadow:0 5px 20px rgba(0,0,0,0.1);">

        <!-- HEADER -->
        <h2 style="margin-bottom:5px; color:#111827;">
            Nueva solicitud de compra
        </h2>

        <p style="color:#6b7280; margin-top:0;">
            Pedido generado desde la tienda Riolobos CP
        </p>

        <hr style="margin:20px 0; border:0; border-top:1px solid #e5e7eb;">

        <!-- USUARIO -->
        <div style="background:#f9fafb; padding:15px; border-radius:10px; margin-bottom:20px;">

            <h3 style="margin-top:0; margin-bottom:10px; color:#111827;">
                Datos del usuario
            </h3>

            <p style="margin:5px 0;">
                <strong>Nombre:</strong> {{ $user->nombre }}
            </p>

            <p style="margin:5px 0;">
                <strong>Apellidos:</strong> {{ $user->apellidos ?? 'No especificado' }}
            </p>

            <p style="margin:5px 0;">
                <strong>Email:</strong> {{ $user->email }}
            </p>

            <p style="margin:5px 0;">
                <strong>Teléfono:</strong> {{ $user->telefono ?? 'No disponible' }}
            </p>

        </div>

        <!-- PRODUCTOS -->
        <h3 style="margin-bottom:10px; color:#111827;">
            Productos del pedido
        </h3>

        <table style="width:100%; border-collapse:collapse; font-size:14px;">

            <thead>
                <tr style="background:#f3f4f6;">
                    <th style="text-align:left; padding:8px;">Producto</th>
                    <th style="text-align:center; padding:8px;">Cant.</th>
                    <th style="text-align:center; padding:8px;">Precio</th>
                    <th style="text-align:center; padding:8px;">Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach($items as $item)
                <tr style="border-bottom:1px solid #e5e7eb;">
                    <td style="padding:8px;">{{ $item->producto->nombre }}</td>
                    <td style="text-align:center;">{{ $item->cantidad }}</td>
                    <td style="text-align:center;">
                        {{ number_format($item->producto->precio,2) }} €
                    </td>
                    <td style="text-align:center;">
                        {{ number_format($item->producto->precio * $item->cantidad,2) }} €
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <hr style="margin:20px 0; border:0; border-top:1px solid #e5e7eb;">

        <!-- TOTALES -->
        <div style="text-align:right;">

            <p style="margin:5px 0;">
                <strong>Total:</strong> {{ number_format($total,2) }} €
            </p>

            <p style="margin:5px 0; color:#16a34a;">
                Descuento socio: -{{ number_format($descuento,2) }} €
            </p>

            <h2 style="margin:10px 0 0;">
                TOTAL FINAL: {{ number_format($totalFinal,2) }} €
            </h2>

        </div>

        <hr style="margin:20px 0; border:0; border-top:1px solid #e5e7eb;">

        <!-- FOOTER -->
        <p style="font-size:12px; color:#9ca3af; text-align:center;">
            Este pedido ha sido generado automáticamente desde la tienda Riolobos CP.
        </p>

    </div>

</body>

</html>