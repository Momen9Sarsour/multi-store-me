<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
        <title>Multi-Store</title>
        <meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta charset="utf-8" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
<body>


<div class="container py-3">
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{route('storeStore')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Store Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Store Name">
        </div>
        <div class="mb-3">
            <label for="imageFormControlInput" class="form-label">Store Image</label>
            <input type="file" class="form-control" id="image" name="image" placeholder="Store Image">
        </div>
        <div class="form-group py-4">
            <label for="">Description</label>
            <textarea class="form-control" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Store email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Store email">
        </div>
        <div class="mb-3">
            <label class="form-label">password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="password">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone NO.</label>
            <input type="phone" class="form-control" id="phone" name="phone" placeholder="Store Phone Number">
        </div>
        <div class="form-group py-4">
            <label for="">Status</label>
               <div>
                 <div class="form-check py-2">
                   <input class="form-check-input" type="radio" name="status" value="active" checked>
                   <label class="form-check-label">Active</label>
                 </div>
                 <div class="form-check py-3">
                   <input class="form-check-input" type="radio" name="status" value="archived">
                   <label class="form-check-label">Archived</label>
                 </div>
               </div>
          </div>
        <div class="mb-3">
            <input type="submit" value="Save" class="btn btn-info">
        </div>
    </form>
</div>


</body>
</html>
