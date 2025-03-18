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
                        <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 24px; font-weight: bold;">Notificación de Compra</h2>
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 40%; font-weight: bold;">Usuario:</td>
                                <td>{{$user->email}}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%; font-weight: bold;">Dirección de Compra:</td>
                                <td>
                                    {{$sales->country}} {{$sales->city}}<br>
                                    {{$sales->address}}<br>
                                    {{$sales->address2}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%; font-weight: bold;">Código Postal:</td>
                                <td>{{$sales->postalCode}}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%; font-weight: bold;">Fecha de Compra:</td>
                                <td>{{$sales->createdAt}}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%; font-weight: bold;">Método de Pago:</td>
                                <td>{{$sales->payment->provider}}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%; font-weight: bold;">Número de Orden:</td>
                                <td>{{$sales->id}}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%; font-weight: bold;">Total:</td>
                                <td>{{$sales->payment->value}}</td>
                            </tr>
                            <tr>
    <td style="width: 40%; font-weight: bold;">Estado de la Compra:</td>
    <td>
        @if($sales->status == 'STORE')
            En tienda
        @elseif($sales->status == 'DISTRIBUTION')
            En distribución
        @elseif($sales->status == 'DELIVERED')
            Entregado
        @else
            {{$sales->status}}
        @endif
    </td>
</tr>
    
                        </table>
                        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                            <tr>
                                <th style="border: 1px solid #000; padding: 8px; font-weight: bold;">Nombre</th>
                                <th style="border: 1px solid #000; padding: 8px; font-weight: bold;">Cantidad</th>
                                <th style="border: 1px solid #000; padding: 8px; font-weight: bold;">Precio</th>
                                <th style="border: 1px solid #000; padding: 8px; font-weight: bold;">Total</th>
                            </tr>
                            @foreach($sales->orderProducts as $product)
                            <tr>
                                <td style="border: 1px solid #000; padding: 8px;">{{$product->product->title}}</td>
                                <td style="border: 1px solid #000; padding: 8px;">{{$product->quantity}}</td>
                                <td style="border: 1px solid #000; padding: 8px;">{{$product->product->price}}</td>
                                <td style="border: 1px solid #000; padding: 8px;">{{$product->product->price * $product->quantity}}</td>
                            </tr>
                            @endforeach
                        </table>
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
                Hola, {{$user->email}}. tu compra ha sido registrada con exito , en breve te enviaremos la confirmacion de tu compra.
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