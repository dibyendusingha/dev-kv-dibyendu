@extends('admin.layout.main')
@section('page-container')
<?php

use Illuminate\Support\Facades\DB;
?>

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Users List</h2>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row align-items-center">


                <div class="col-md-4 ms-auto">
                    <form action="#">
                        <div class="input-group overflow-hidden">
                            <input type="text" id="searchInput" oninput="performSearch()" class="form-control rounded-0" placeholder="Search..">
                            <button type="submit" class="bg-secondary text-white border-0"><i class="icon material-icons md-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>User Type</th>
                            <th>Mobile</th>
                            <th>Post Count</th>
                            <th>Post Limit</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_tbody">
                        @foreach($user_details as $key => $user)

                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->name}}</td>
                            <td>
                                <span class="badge badge-pill badge-soft-<?php if ($user->user_type_id == 1) {
                                                                                echo 'warning';
                                                                            } else if ($user->user_type_id == 2) {
                                                                                echo 'success';
                                                                            } else if ($user->user_type_id == 3) {
                                                                                echo 'info';
                                                                            } else {
                                                                                echo 'danger';
                                                                            } ?>"><?php if ($user->user_type_id == 1) {
                                                                                echo 'Individual';
                                                                            } else if ($user->user_type_id == 2) {
                                                                                echo 'Seller';
                                                                            } else if ($user->user_type_id == 3) {
                                                                                echo 'Dealer';
                                                                            } else {
                                                                                echo 'Exchanger';
                                                                            } ?></span>
                            </td>
                            <td>{{$user->mobile}}</td>
                            <td>{{$user->user_post_count}}</td>
                            <td>{{$user->limit_count}}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <a href="" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="user-details/{{$user->id}}">View Details</a>

                                    </div>
                                </div>
                                <!-- dropdown //end -->
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    <div class="pagination-area mt-30 mb-50">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">

            </ul>
        </nav>
    </div>
</section>
<!-- content-main end// -->

<script>
        function performSearch() {
        // Get input element and filter value
        var input = document.getElementById("searchInput");
        var filter = input.value.toUpperCase();

        // Get table rows
        var table = document.getElementById("myTable");
        var rows = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those that don't match the search query
            for (var i = 1; i < rows.length; i++) { // starting from 1 to skip the header row
                var shouldDisplay = false;
                var cells = rows[i].getElementsByTagName("td");
                
                // Loop through all cells in the current row
                for (var j = 0; j < cells.length; j++) {
                var cellText = cells[j].innerText || cells[j].textContent;
                
                // Check if the cell text matches the search query
                if (cellText.toUpperCase().indexOf(filter) > -1) {
                    shouldDisplay = true;
                    break;
                }
                }

                // Display or hide the row based on the search result
                rows[i].style.display = shouldDisplay ? "" : "none";
            }
        }
    </script>

@endsection