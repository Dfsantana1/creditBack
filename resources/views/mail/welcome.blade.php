@extends('mail.layout')
@section('title', 'Welcome to Robin')
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
							<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"> Hola, {{$user->profile->firstName}},</p>
							<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
								Bienvenido a  LAZO
							</p>
							<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
							Te han otorgado como... <b>{{ \Illuminate\Support\Str::headline(strtolower($role->name))}}</b> Acceso para LAZO>{{ $entityName }}</b>.
							Sigue las instrucciones para restablecer tu contraseña o inicia sesión aquí: <a href="https://lazomascotas.com:444/#/account/auth/recoverpwd-2">Lazo Restablecer Contraseña</a>
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
