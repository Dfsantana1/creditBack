@if( !isset($hideRegards) )
	<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0 0 15px;">Saludos, <br/><b>Lazo</b></p>
	<br />
@endif
<hr style="border-top: 1px #C0C0C0"/>
<p style="font-family: sans-serif; font-size: 11px; font-weight: normal; margin: 0 0 15px;color:#C0C0C0">
Si recibiste este correo de confirmación sin haberlo solicitado, es probable que alguien haya ingresado accidentalmente tu correo electrónico. No es necesario tomar ninguna medida adicional</p>
<p style="font-size: 11px;color:#C0C0C0">Si no reconoces este correo, puedes informar a.. <a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}">{{ env('MAIL_FROM_ADDRESS') }}</a>  comunicarles al respecto, con suerte, esto ayudará.</p>
