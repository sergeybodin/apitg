@section('styles')
    <style>
        @font-face {
            font-family: 'PT Sans';
            src: local('PT Sans'), local('PTSans-Regular'), url({{url('css/fonts/ptsans/PT_Sans-Web-Regular.ttf')}}) format('truetype');
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: 'PT Sans';
            src: local('PT Sans Italic'), local('PTSans-Italic'), url({{url('css/fonts/ptsans/PT_Sans-Web-Italic.ttf')}}) format('truetype');
            font-weight: 400;
            font-style: italic;
        }
        @font-face {
            font-family: 'PT Sans';
            src: local('PT Sans Bold'), local('PTSans-Bold'), url({{url('css/fonts/ptsans/PT_Sans-Web-Bold.ttf')}}) format('truetype');
            font-weight: 600;
            font-style: normal;
        }
        @font-face {
            font-family: 'PT Sans';
            src: local('PT Sans Bold Italic'), local('PTSans-BoldItalic'), url({{url('css/fonts/ptsans/PT_Sans-Web-BoldItalic.ttf')}}) format('truetype');
            font-weight: 600;
            font-style: italic;
        }

		.mb-10 {margin-bottom:10px;}
		.mb-25 {margin-bottom:25px;}
		.mb-30 {margin-bottom:30px;}

        .wrapper {font-family:"PT Sans", sans-serif; font-size:16px; color:#585858;}
		p {margin:0 0 20px;}
		.header {font-size:24px; font-weight:600;}

		.footer {margin-top:30px;}
		.footer .logo {margin-bottom:10px;}

    </style>
@endsection