@extends('mail.layout')
@section('title', 'Page Title')
@section('content')

<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
    <tr>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                Hola Admin</p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                Este usuario quiere Ofrecerte los siguientes Productos!<br />
                <br />
                <br />
            </p>
   
        </td>
    </tr><!-- START MAIN CONTENT AREA -->
    <tr>

        <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top">
            <table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;" width="100%">
                <tr>
                    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
                            <tr>
                                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                    <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 24px; font-weight: bold;">Información del Producto del Vendedor</h2>
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Nombre de la Empresa:</td>
                                            <td>{{ $vendorProduct->companyName }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Nombre de Contacto:</td>
                                            <td>{{ $vendorProduct->contactName }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Correo Electrónico:</td>
                                            <td>{{ $vendorProduct->email }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Dirección:</td>
                                            <td>{{ $vendorProduct->address }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Descripción del Producto:</td>
                                            <td>{{ $vendorProduct->productDescription }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Teléfono:</td>
                                            <td>{{ $vendorProduct->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Nombre del Producto:</td>
                                            <td>{{ $vendorProduct->productName }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Precio de Venta:</td>
                                            <td>{{ $vendorProduct->sellingPrice }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Precio al por Mayor:</td>
                                            <td>{{ $vendorProduct->wholesalePrice }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-weight: bold;">Cantidad Mínima:</td>
                                            <td>{{ $vendorProduct->minQuantity }}</td>
                                        </tr>
                                        <tr>
    <td style="width: 40%; font-weight: bold;">ARCHIVO</td>
    <td>
        @php
        $fileUrl = $vendorProduct->fileURL; // Suponiendo que $vendorProduct->file_url contiene la URL del archivo PDF
        @endphp

        @if($fileUrl)
            <a href="{{ $fileUrl }}" target="_blank">Ver PDF</a>
        @else
            No hay archivo disponible.
        @endif
    </td>
</tr>
                                    </table>
                                </td>
                            </tr>
                        </table>


                    </td>
                </tr>
            </table>
        </td>
        @include('mail/sign')
    </tr>
</table>



<!-- START TABLE -->


<!-- END TABLE -->
@endsection