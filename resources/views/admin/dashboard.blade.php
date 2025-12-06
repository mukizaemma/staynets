@extends('layouts.adminBase')


@section('content')


        <!-- Sidebar Start -->
@include('admin.includes.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('admin.includes.navbar')
            <!-- Navbar End -->


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Site Visitors</p>
                                <h6 class="mb-0"><a href="https://analytics.google.com/analytics/web/#/p468682803/reports/intelligenthome" class="btn btn-dark" target="_blank">Google Analytics</a></h6>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Rooms</p>
                                <h6 class="mb-0"><a >{{$rooms}}</a></h6>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fas fa-thumbs-up fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Product Reviews</p>
                                <h6 class="mb-0">{{ $productCommetsCount }}</h6>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fas fa-comments fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Orders</p>
                                {{-- <h6 class="mb-0"><a href="{{ route('blogsComment') }}">{{ $blogCommetsCount }}</a></h6> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->

            <!-- Sales Chart Start -->
     


            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Orders</h6>
                        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search here" class="form-control" style="width: 200px;">
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Names</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                                @foreach($subscribers as $rs)
                                <tr>
                                    <td><input class="form-check-input" type="checkbox"></td>
                                    <td>{{ $rs->created_at }}</td>
                                    <td>{{ $rs->names ?? '' }}</td>
                                    <td>{{ $rs->service ?? '' }}</td>
                                    <td>{{ $rs->email }}</td>
                                    <td>
                                        <div class="btn-btn-group ">
                                            <a type="button" href="{{ route('destroySub', $rs->id) }}"
                                                class="btn btn-danger text-black" onclick="return confirm('Are you sure to delete this item?')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            {{ $subscribers->links('pagination::simple-bootstrap-4', ['style' => 'margin-top: 20px;']) }} --}}


                        </table>
                    </div>
                </div>
            </div>

            <script>
                function searchTable() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("searchInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementsByClassName("table")[0];
                    tr = table.getElementsByTagName("tr");
            
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[2]; // Change index to match the column you want to search
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script>
            
            <!-- Recent Sales End -->



            <!-- Footer Start -->
            @include('admin.includes.footer')
            <!-- Footer End -->
        </div>
        <!-- Content End -->



 @endsection