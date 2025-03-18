@extends('mail.layout')

@section('title', 'Nueva Reseña Creada')

@section('content')
<table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;" width="100%">
    <!-- START MAIN CONTENT AREA -->
    <tr>
        <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
                <tr>
                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                        <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 24px; font-weight: bold;">Nueva Reseña Creada</h2>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                            Hola, Admin. Se ha creado una nueva reseña en Lazo.
                        </p>
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 40%; font-weight: bold;">Título:</td>
                                <td>{{ $review->title }}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%; font-weight: bold;">Contenido:</td>
                                <td>{{ $review->content }}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%; font-weight: bold;">Valoración:</td>
                                <td>{{ $review->valoration }}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%; font-weight: bold;">Usuario:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- END MAIN CONTENT AREA -->
</table>
@endsection
