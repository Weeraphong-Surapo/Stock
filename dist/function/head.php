<!DOCTYPE html>
<html lang="en" dir="ltr" data-theme="light">

<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&amp;family=Roboto+Mono&amp;display=swap" rel="stylesheet">
	<link href="assets/build/styles/ltr-core.css" rel="stylesheet">
	<link href="assets/build/styles/ltr-vendor.css" rel="stylesheet">
	<link href="assets/images/favicon.ico" rel="shortcut icon" type="image/x-icon">
	<title>System Stock</title>
	<script src="assets/js/jquery-3.3.1.js"></script>

	<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->


	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

	<!-- Datatables JS -->
	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap4.min.js"></script>

</html>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>

<style>
	@media screen and (max-width:1024px) {
		body.aside-active.aside-desktop-maximized .wrapper {
			padding-left: 0 !important;
		}

		body.aside-active.aside-desktop-minimized .wrapper {
			padding-left: 0 !important;
		}
	}

	@media (min-width: 1025px) {

		body.aside-active.aside-desktop-maximized .sticky-header {
			left: 0 !important;
		}
	}
</style>
<?php
if (isset($_GET['p']) && $_GET['p'] != 'home' && $_GET['p'] != 'salepic') {
	echo '<style>
        body.aside-active.aside-desktop-maximized .wrapper {
            padding-left: 22.5rem; }
        body.aside-active.aside-desktop-minimized .wrapper {
            padding-left: 4.5rem; }

        </style>';
} else {
	echo '<style>
        body.aside-active.aside-desktop-maximized .wrapper {}
        body.aside-active.aside-desktop-minimized .wrapper {}
		body.aside-active.aside-desktop-maximized .sticky-header{	}
        </style>';
}

?>
</head>

<body class="preload-active aside-active aside-mobile-minimized aside-desktop-maximized">
	<!-- BEGIN Preload -->
	<div class="preload">
		<div class="preload-dialog">
			<!-- BEGIN Spinner -->
			<div class="spinner-border text-primary preload-spinner"></div>
			<!-- END Spinner -->
		</div>
	</div>
	<!-- END Preload -->