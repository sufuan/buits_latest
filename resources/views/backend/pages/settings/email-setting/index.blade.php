@extends('Backend.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Email Format Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <!-- CKEditor Section -->
                            <div class="flex-grow-1 pr-3">
                                <div class="form-group">
                                    <label class="form-label">Main Title</label>
                                    <input type="text" name="title[]" placeholder="Order has been placed successfully!" class="form-control">
                                </div>
                                <div class="form-group mb-0">
                                    <label class="form-label">Mail Body Message</label>
                                    <textarea id="ckeditor" class="ckeditor form-control" name="body[]">Hi Sabrina, </textarea>
                                </div>
                            </div>

                            <!-- Preview Section -->
                            <div class="preview-container" style="width: 400px; border: 1px solid #ddd; padding: 20px; background-color: #f9f9f9;">
                                <h4>Email Preview</h4>
                                <div id="email-preview">
                                    <h3 id="preview-title">Order has been placed successfully!</h3>
                                    <div>
                                        <p id="preview-body">Hi Sabrina, </p>
                                    </div>
                                    <div>
                                        <p id="footer-text">Please contact us for any queries; we’re always happy to help.</p>
                                        <p id="copyright-text">Copyright 2023 6amMart. All rights reserved.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div>
                            <h5 class="card-title mb-3">
                                <img src="{{ asset('public/assets/admin/img/pointer.png') }}" class="mr-2" alt="">
                                Footer Content
                            </h5>
                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label class="form-label">Section Text</label>
                                    <input type="text" id="footer-text-input" placeholder="Please contact us for any queries; we’re always happy to help." class="form-control">
                                </div>
                                <div class="form-group mb-0">
                                    <label class="form-label">Copyright Content</label>
                                    <input type="text" id="copyright-text-input" placeholder="Ex: Copyright 2023 6amMart. All rights reserved." class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-3">
                            <button type="reset" id="reset_btn" class="btn btn--reset">Reset</button>
                            <button type="submit" class="btn btn--primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Update Status Modal -->
            <div class="modal fade" id="place-order-status-modal">
                <div class="modal-dialog status-warning-modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true" class="tio-clear"></span>
                            </button>
                        </div>
                        <div class="modal-body pb-5 pt-0">
                            <div class="max-349 mx-auto mb-20">
                                <div>
                                    <div class="text-center">
                                        <img src="{{ asset('/public/assets/admin/img/modal/place-order-off.png') }}" alt="" class="mb-20">
                                        <h5 class="modal-title">Want to disable Place Order</h5>
                                    </div>
                                    <div class="text-center">
                                        <p>User will not get a confirmation email when they placed an order.</p>
                                    </div>
                                </div>
                                <div class="btn--container justify-content-center">
                                    <button type="submit" class="btn btn--primary min-w-120" data-dismiss="modal">Ok</button>
                                    <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions Modal -->
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        // Initialize CKEditor
        var editor = CKEDITOR.replace('ckeditor');

        // Live update the email preview when editor content changes
        editor.on('change', function(evt) {
            $('#preview-body').html(evt.editor.getData());
        });

        // Update footer text in the preview
        $('#footer-text-input').on('keyup', function() {
            var value = $(this).val();
            $('#footer-text').text(value);
        });

        // Update copyright text in the preview
        $('#copyright-text-input').on('keyup', function() {
            var value = $(this).val();
            $('#copyright-text').text(value);
        });

        // Function to read URLs for uploaded images
        function readURL(input, viewer) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + viewer).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#mail-logo").change(function() {
            readURL(this, 'logoViewer');
        });

        $("#mail-banner").change(function() {
            readURL(this, 'bannerViewer');
        });

        $("#mail-icon").change(function() {
            readURL(this, 'iconViewer');
        });
    </script>
@endpush
