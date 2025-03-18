<!doctype html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>LAZO Transactional Email</title>
	<style>
		@media only screen and (max-width: 620px) {
			table.body h1 {
				font-size: 28px !important;
				margin-bottom: 10px !important;
			}

			table.body p,
			table.body ul,
			table.body ol,
			table.body td,
			table.body span,
			table.body a {
				font-size: 16px !important;
			}

			table.body .wrapper,
			table.body .article {
				padding: 10px !important;
			}

			table.body .content {
				padding: 0 !important;
			}

			table.body .container {
				padding: 0 !important;
				width: 100% !important;
			}

			table.body .main {
				border-left-width: 0 !important;
				border-radius: 0 !important;
				border-right-width: 0 !important;
			}

			table.body .btn table {
				width: 100% !important;
			}

			table.body .btn a {
				width: 100% !important;
			}

			table.body .img-responsive {
				height: auto !important;
				max-width: 100% !important;
				width: auto !important;
			}
		}

		@media all {
			.ExternalClass {
				width: 100%;
			}

			.ExternalClass,
			.ExternalClass p,
			.ExternalClass span,
			.ExternalClass font,
			.ExternalClass td,
			.ExternalClass div {
				line-height: 100%;
			}

			.apple-link a {
				color: inherit !important;
				font-family: inherit !important;
				font-size: inherit !important;
				font-weight: inherit !important;
				line-height: inherit !important;
				text-decoration: none !important;
			}

			#MessageViewBody a {
				color: inherit;
				text-decoration: none;
				font-size: inherit;
				font-family: inherit;
				font-weight: inherit;
				line-height: inherit;
			}

			.btn-primary table td:hover {
				background-color: #34495e !important;
			}

			.btn-primary a:hover {
				background-color: #34495e !important;
				border-color: #34495e !important;
			}
		}
	</style>
</head>
<body style="background-color: {{ isset($corporationColor) ? $corporationColor : '#f6f6f6' }}; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
<span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">@yield('preHeader')</span>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: {{ isset($corporationColor) ? $corporationColor : '#f6f6f6' }}; width: 100%;" width="100%" bgcolor="{{ isset($corporationColor) ? $corporationColor : '#f6f6f6' }}">
	<tr>
		<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
		<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;" width="580" valign="top">
			<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">

				<table style="text-align: center;margin: 15px auto;">
					<tr>
						<td>
							<img src="{{ env('LOGO_URL') }}"
							     alt="{{config('app.name')}}" width="180px"/>
						</td>
					</tr>
				</table>

				<!-- START CENTERED WHITE CONTAINER -->
				@yield('content')
				<!-- END CENTERED WHITE CONTAINER -->

				<!-- START FOOTER -->	
				<div class="footer" style="clear: both; margin-top: 10px; text-align: center; width: 100%;">
					<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
						<tr>
							<td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;" valign="top" align="center">
								<span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">LAZO <br/>8186 Woodland Center Blvd Tampa, FL 33614</span>
								<br> Don't like these emails? <a href="#" style="text-decoration: underline; color: #999999; font-size: 12px; text-align: center;">Unsubscribe</a>.
							</td>
						</tr>
						<tr>
							<td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;" valign="top" align="center">
								Powered by <a href="https://lazomascotas.com:444/" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;">Lazo</a>.
							</td>
						</tr>
					</table>
				</div>
				<!-- END FOOTER -->

			</div>
		</td>
		<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
	</tr>
</table>
</body>
</html>