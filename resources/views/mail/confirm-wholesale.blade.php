@extends('mail.layout')
@section('title', 'Page Title')
@section('content')
<table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;" width="100%">
    <!-- START MAIN CONTENT AREA -->
    <tr>
        <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top">
            <table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;" width="100%">
                <tr>
                    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
                            <tr>
                                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                    <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 24px; font-weight: bold;">Informacion Usuario Mayorista </h2>
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Is Approved:</td>
                                            <td>{{$wholesaleUser->isApproved ? 'Yes' : 'No'}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">User Email:</td>
                                            <td>{{$user->email}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Company Name:</td>
                                            <td>{{$wholesaleUser->companyName}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Purchase Volume:</td>
                                            <td>{{$wholesaleUser->purchaseVolume}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Company Size:</td>
                                            <td>{{$wholesaleUser->companySize}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Phone:</td>
                                            <td>{{$wholesaleUser->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Address:</td>
                                            <td>{{$wholesaleUser->address}}</td>
                                        </tr>
                                 
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Notes:</td>
                                            <td>{{$wholesaleUser->notes}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">RUT:</td>
                                      
                                        </tr>

                                    </table>
                                    
                                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" style="text-decoration: none; border: 0;">
    <img src="{{ $url }}" alt="Imagen Relacionada" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
</a>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
                <tr>
                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                             Hola Admin</p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                            Este usuario quiere ser mayorista!<br />
                            Seleciona una Opcion Para este usuario Agregarlo Como Mayorista o Eliminar su Solitud
                            <br />
                            <br />
                            <a href="https://lazomascotas.com:8000/api/{{$user->id}}/wholesale-confirmation" target="_blank" style="border: solid 1px #07b59a; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 8px 12px; text-decoration: none; text-transform: capitalize; background-color: #07b59a; border-color: #07b59a; color: #ffffff;">
                               Aceptar Usuario
                            </a>
                            <a href="https://lazomascotas.com:8000/api/{{$user->id}}/wholesale-denial" target="_blank" style="border: solid 1px #ff4d4f; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 8px 12px; text-decoration: none; text-transform: capitalize; background-color: #ff4d4f; border-color: #ff4d4f; color: #ffffff;">
                                Denegar solicitud
                            </a>

                        </p>
                        @include('mail/sign')
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- END MAIN CONTENT AREA -->
</table>

<!-- START TABLE -->


<!-- END TABLE -->
@endsection