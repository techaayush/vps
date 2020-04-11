<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Positive Vibes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico"> -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/metisMenu.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/slicknav.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/data-table/css/jquery.dataTables.min.css')}}">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="{{asset('assets/css/typography.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/default-css.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <!-- modernizr css -->
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="index.html"><!-- <img src="assets/images/logo.png" alt="logo"> --><h3>LOGO</h3></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li ><a href="index.html"><i class="ti-dashboard"></i> <span>Dashboard</span></a></li>
                            <li class="active"><a href=""><i class="ti-receipt"></i> <span>Category</span></a>
                            </li>
                            <li><a href="{{route('positive-vibes')}}"><i class="ti-receipt"></i> <span>Positive Vibes</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <div class="header-area">
                <div class="row align-items-center m-0">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix pr-0">
                        <div class="user-profile pull-right">
                            <h4 class="user-name " > <a href="login.html"><i class="ti-power-off"></i> Log Out</a> </h4>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="main-content-inner">
                <!-- sales report area start -->
                <div class="mt-4 mb-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="header-title mb-0">Category List </h4>
                                        <a class="add-btn" href="#"  data-toggle="modal" data-target="#addCategory"><i class="ti-plus"></i> Add Category</a>
                                    </div>
                                    <div class="table-responsive mt-4">
                                        <table id="table_id" class="table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Emoji Name</th>
                                                    <th>Image</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><img src="assets/images/love.png" class="img-fluid" /></td>
                                                    <td>Heart Eye Emoji</td>
                                                    <td><a href="#" class="mr-2"><i class="ti-pencil-alt"></i></a><a href="#" class="text-danger"><i class="ti-archive"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td><img src="assets/images/joy.png" class="img-fluid" /></td>
                                                    <td>Joy Emoji</td>
                                                    <td><a href="#" class="mr-2"><i class="ti-pencil-alt"></i></a><a href="#" class="text-danger"><i class="ti-archive"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td><img src="assets/images/smile.png" class="img-fluid" /></td>
                                                    <td>Happy Face Emoji</td>
                                                    <td><a href="#" class="mr-2"><i class="ti-pencil-alt"></i></a><a href="#" class="text-danger"><i class="ti-archive"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td><img src="assets/images/smart.png" class="img-fluid" /></td>
                                                    <td>Sunglasses Emoji</td>
                                                    <td><a href="#" class="mr-2"><i class="ti-pencil-alt"></i></a><a href="#" class="text-danger"><i class="ti-archive"></i></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Copyright 2018. All right reserved. Template by <a href="https://colorlib.com/wp/">Colorlib</a>.</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>

    <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" action="{{route('add-category')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for=""> Name</label>
                        <input type="text" name="emoji_name" class="form-control" id="" placeholder="" value="" required="" style="display: none;">
                    </div><div class="col-md-12 mb-3">
                        <!-- <label for=""> Upload Image</label> -->
                        <input type="file" id="real-file" name="emoji_image" style="display: none;" />
                        <button type="button" id="custom-button">Upload File</button>
                        <span id="custom-text">No file chosen, yet.</span>
                        <!-- <input type="file" class="form-control" id="" placeholder="" value="" required=""> -->
                    </div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="default-btn" data-dismiss="modal">Close</button>
            <button type="button" class="add-btn" id="add">Save </button>
          </div>
        </div>
      </div>
    </div>

    <!-- page container area end -->
    <!-- jquery latest version -->
    <script src="{{asset('assets/js/jquery-2.2.4.min.js')}}"></script>
    <!-- bootstrap 4 js -->
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/data-table/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.slicknav.min.js')}}"></script>

    <script src="{{asset('assets/js/scripts.js')}}"></script>

    <script type="text/javascript">
        $('#add').click(function (e) {
            $('form').submit();
        })
    </script>
</body>

</html>
