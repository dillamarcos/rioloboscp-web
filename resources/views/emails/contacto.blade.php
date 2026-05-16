<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Nuevo mensaje de contacto</title>
</head>

<body style="padding: 30px 10px; margin:0; background:#f3f4f6; font-family:Arial, sans-serif;">

    <div
        style="max-width:600px; margin:40px auto; background:white; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">

        <!-- HEADER -->
        <div style="background:#4f46e5; padding:20px; text-align:center;">
            <img src="{{ asset('images/escudo_nav.png') }}" alt="Riolobos CP" style="height:60px; margin-bottom:10px;">

            <h2 style="color:white; margin:0;">Nuevo mensaje de contacto</h2>
        </div>

        <!-- CONTENIDO -->
        <div style="padding:20px; color:#333;">

            <p><strong>Email del usuario:</strong></p>
            <p style="background:#f9fafb; padding:10px; border-radius:6px;">
                {{ $datos['email'] }}
            </p>

            <p><strong>Mensaje:</strong></p>
            <div style="background:#f9fafb; padding:10px; border-radius:6px;">
                {{ $datos['mensaje'] }}
            </div>

        </div>

        <!-- FOOTER -->
        <div style="background:#f3f4f6; padding:15px; text-align:center; font-size:12px; color:#666;">
            Riolobos CP © {{ date('Y') }} - Sistema de contacto
        </div>

    </div>

</body>

</html>