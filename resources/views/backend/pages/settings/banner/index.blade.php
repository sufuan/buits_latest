@extends('backend.layouts.master')

@section('title')
Admin Create - Admin Panel
@endsection

@section('admin-content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="public/assets/admin/img/banner.png" class="w--26" alt="">
            </span>
            <span>
                Add New Banner
            </span>
        </h1>
    </div>
    <!-- End Page Header -->
    <div class="row gx-2 gx-lg-3">
        <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <div class="card">
                <div class="card-body">
                    <form action="#" method="post" id="banner_form">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <ul class="nav nav-tabs mb-3 border-0">
                                    <li class="nav-item">
                                        <a class="nav-link lang_link active" href="#" id="default-link">Default</a>
                                    </li>
                                    <!-- Add other language tabs here if needed -->
                                </ul>
                                <div class="lang_form" id="default-form">
                                    <div class="form-group">
                                        <label class="input-label" for="default_title">Title (Default)</label>
                                        <input type="text" name="title[]" id="default_title" class="form-control" placeholder="New Banner">
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                </div>
                                <!-- Add other language forms here if needed -->
                                <div class="form-group">
                                    <label class="input-label" for="title">Zone</label>
                                    <select name="zone_id" id="zone" class="form-control js-select2-custom">
                                        <option disabled selected>---Select---</option>
                                        <!-- Add other zone options here if needed -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlInput1">Banner Type</label>
                                    <select name="banner_type" id="banner_type" class="form-control" onchange="banner_type_change(this.value)">
                                        <option value="store_wise">Store Wise</option>
                                        <option value="item_wise">Item Wise</option>
                                        <option value="default">Default</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0" id="store_wise">
                                    <label class="input-label" for="exampleFormControlSelect1">Store</label>
                                    <select name="store_id" id="store_id" class="js-data-example-ajax form-control" title="Select Restaurant">
                                        <!-- Add store options here if needed -->
                                    </select>
                                </div>
                                <div class="form-group mb-0" id="item_wise">
                                    <label class="input-label" for="exampleFormControlInput1">Select Item</label>
                                    <select name="item_id" id="choice_item" class="form-control js-select2-custom" placeholder="Select Item">
                                        <!-- Add item options here if needed -->
                                    </select>
                                </div>
                                <div class="form-group mb-0" id="default">
                                    <label class="input-label" for="exampleFormControlInput1">Default Link (Optional)</label>
                                    <input type="text" name="default_link" class="form-control" placeholder="Default Link">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="h-100 d-flex flex-column">
                                    <label class="mt-auto mb-0 d-block text-center">Banner Image <small class="text-danger">* ( Ratio 3:1 )</small></label>
                                    <center class="py-3 my-auto">
                                        <img class="img--vertical" id="viewer" src="public/assets/admin/img/900x400/img1.jpg" alt="banner image" />
                                    </center>
                                    <div class="custom-file">
                                        <input type="file" name="image" id="customFileEg1" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                        <label class="custom-file-label" for="customFileEg1">Choose File</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="btn--container justify-content-end">
                                    <button type="reset" id="reset_btn" class="btn btn--reset">Reset</button>
                                    <button type="submit" class="btn btn--primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <div class="card">
                <div class="card-header py-2 border-0">
                    <div class="search--button-wrapper">
                        <h5 class="card-title">Banner List <span class="badge badge-soft-dark ml-2" id="itemCount">2</span></h5>
                        <form id="search-form" class="search-form">
                            <!-- Search -->
                            <div class="input-group input--group">
                                <input id="datatableSearch" type="search" name="search" class="form-control" placeholder="Search by Title" aria-label="Search Here">
                                <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>
                </div>
                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0">SL</th>
                                <th class="border-0">Title</th>
                                <th class="border-0">Module</th>
                                <th class="border-0">Type</th>
                                <th class="border-0 text-center">Featured</th>
                                <th class="border-0 text-center">Status</th>
                                <th class="border-0 text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody id="set-rows">
                            <tr>
                                <td>1</td>
                                <td>
                                    <span class="media align-items-center">
                                        <img class="img--ratio-3 w-auto h--50px rounded mr-2" src="public/assets/admin/img/sample1.jpg" alt="Sample Image 1">
                                        <div class="media-body">
                                            <h5 class="text-hover-primary mb-0">Sample Banner 1</h5>
                                        </div>
                                    </span>
                                </td>
                                <td>Module 1</td>
                                <td>Store Wise</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-featured" type="checkbox" role="switch" id="featuredSwitch1">
                                            <label class="form-check-label" for="featuredSwitch1">Featured</label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-status" type="checkbox" role="switch" id="statusSwitch1" checked>
                                            <label class="form-check-label" for="statusSwitch1">Status</label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary" href="#" title="Edit Banner"><i class="tio-edit"></i></a>
                                        <a class="btn action-btn btn--danger btn-outline-danger" href="#" title="Delete Banner"><i class="tio-delete-outlined"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <span class="media align-items-center">
                                        <img class="img--ratio-3 w-auto h--50px rounded mr-2" src="public/assets/admin/img/sample2.jpg" alt="Sample Image 2">
                                        <div class="media-body">
                                            <h5 class="text-hover-primary mb-0">Sample Banner 2</h5>
                                        </div>
                                    </span>
                                </td>
                                <td>Module 2</td>
                                <td>Item Wise</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-featured" type="checkbox" role="switch" id="featuredSwitch2" checked>
                                            <label class="form-check-label" for="featuredSwitch2">Featured</label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-status" type="checkbox" role="switch" id="statusSwitch2">
                                            <label class="form-check-label" for="statusSwitch2">Status</label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary" href="#" title="Edit Banner"><i class="tio-edit"></i></a>
                                        <a class="btn action-btn btn--danger btn-outline-danger" href="#" title="Delete Banner"><i class="tio-delete-outlined"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->
                <div class="page-area">
                    <table>
                        <tfoot>
                            <tr>
                                <div class="d-flex justify-content-center justify-content-sm-end">
                                    <nav>
                                        <ul class="pagination">
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">1</a>
                                            </li>
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link">2</span>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="empty--data">
                    <img src="public/assets/admin/svg/illustrations/sorry.svg" alt="public">
                    <h5>No data found</h5>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event listeners for status switches
        document.querySelectorAll('.toggle-status').forEach(function(switchElement) {
            switchElement.addEventListener('change', function(event) {
                if (event.target.checked) {
                    console.log('on');
                } else {
                    console.log('off');
                }
            });
        });

        // Event listeners for featured switches
        document.querySelectorAll('.toggle-featured').forEach(function(switchElement) {
            switchElement.addEventListener('change', function(event) {
                if (event.target.checked) {
                    console.log('on');
                } else {
                    console.log('off');
                }
            });
        });

        // Search functionality
        const searchInput = document.getElementById('datatableSearch');
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('#set-rows tr');
            rows.forEach(function(row) {
                const titleCell = row.querySelector('td:nth-child(2) h5');
                const title = titleCell.textContent.toLowerCase();
                if (title.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection