@extends('mail.layout')
@section('title', 'Page Title')
@section('content')
    <table role="presentation" class="main"
           style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;"
           width="100%">
        <!-- START MAIN CONTENT AREA -->
        <tr>
            <td class="wrapper"
                style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;"
                valign="top">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                       style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;"
                       width="100%">
                    <tr>
                        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                                Hi there,</p>
                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                            Estás recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para tu cuenta<br>
                            Hemos generado un código para su uso
                                <b>{{$passwordReset->token}}</b>
                            </p>
	                        @include('mail/sign')
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- END MAIN CONTENT AREA -->
    </table>
@endsection