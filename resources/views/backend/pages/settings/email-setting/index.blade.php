@extends('Backend.layouts.master')

@section('admin-content')
<div class="content-wrapper">
    <div class="container-fluid">
        <form action="{{ route('admin.settings.email.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                                <input type="text" name="title" id="email-title" class="form-control" placeholder="Your Registration is Successful!">
                            </div>
                            <div class="form-group mb-0">
                                <label class="form-label">Mail Body Message</label>
                                <textarea id="ckeditor" class="ckeditor form-control" name="body">Congratulations! You’ve successfully registered.</textarea>
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div class="preview-container" style="width: 400px; border: 1px solid #ddd; padding: 20px; background-color: #f9f9f9;">
                            <h4>Email Preview</h4>
                            <div id="email-preview">
                                <h3 id="preview-title">Your Registration is Successful!</h3>
                                <div>
                                    <p id="preview-body">Congratulations! You’ve successfully registered.</p>
                                </div>
                                <div>
                                    <p id="preview-footer">Please contact us for any queries; we’re always happy to help.</p>
                                    <p id="preview-copyright">© 2023 Your Company</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <!-- Footer Content Customization -->
                    <h5 class="card-title mb-3">Footer Content</h5>
                    <div class="form-group">
                        <label class="form-label">Section Text</label>
                        <input type="text" name="footer_text" id="footer-text-input" class="form-control" placeholder="Please contact us for any queries; we’re always happy to help." required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Copyright Text</label>
                        <input type="text" name="copyright_text" id="copyright-text-input" class="form-control" placeholder="© 2023 Your Company">
                    </div>

                    <!-- Page Links Section -->
                    <div class="form-group">
                        <label class="form-label">Page Links</label>
                        <div class="d-flex flex-wrap">
                            <div class="form-check pr-3">
                                <input type="hidden" name="privacy_policy" value="0">
                                <input type="checkbox" class="form-check-input" id="privacy-policy" name="privacy_policy" value="1" checked>
                                <label class="form-check-label" for="privacy-policy">Privacy Policy</label>
                            </div>
                            <div class="form-check pr-3">
                                <input type="hidden" name="refund_policy" value="0">
                                <input type="checkbox" class="form-check-input" id="refund-policy" name="refund_policy" value="1" checked>
                                <label class="form-check-label" for="refund-policy">Refund Policy</label>
                            </div>
                            <div class="form-check pr-3">
                                <input type="hidden" name="cancellation_policy" value="0">
                                <input type="checkbox" class="form-check-input" id="cancellation-policy" name="cancellation_policy" value="1" checked>
                                <label class="form-check-label" for="cancellation-policy">Cancellation Policy</label>
                            </div>
                            <div class="form-check pr-3">
                                <input type="hidden" name="contact_us" value="0">
                                <input type="checkbox" class="form-check-input" id="contact-us" name="contact_us" value="1" checked>
                                <label class="form-check-label" for="contact-us">Contact Us</label>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links Section -->
                    <div class="form-group">
                        <label class="form-label">Social Media Links</label>
                        <div class="d-flex flex-wrap">
                            <div class="form-check pr-3">
                                <input type="hidden" name="facebook" value="0">
                                <input type="checkbox" class="form-check-input" id="facebook" name="facebook" value="1" checked>
                                <label class="form-check-label" for="facebook">Facebook</label>
                            </div>
                            <div class="form-check pr-3">
                                <input type="hidden" name="instagram" value="0">
                                <input type="checkbox" class="form-check-input" id="instagram" name="instagram" value="1" checked>
                                <label class="form-check-label" for="instagram">Instagram</label>
                            </div>
                            <div class="form-check pr-3">
                                <input type="hidden" name="twitter" value="0">
                                <input type="checkbox" class="form-check-input" id="twitter" name="twitter" value="1">
                                <label class="form-check-label" for="twitter">Twitter</label>
                            </div>
                            <div class="form-check pr-3">
                                <input type="hidden" name="linkedin" value="0">
                                <input type="checkbox" class="form-check-input" id="linkedin" name="linkedin" value="1" checked>
                                <label class="form-check-label" for="linkedin">LinkedIn</label>
                            </div>
                            <div class="form-check pr-3">
                                <input type="hidden" name="pinterest" value="0">
                                <input type="checkbox" class="form-check-input" id="pinterest" name="pinterest" value="1" checked>
                                <label class="form-check-label" for="pinterest">Pinterest</label>
                            </div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    var editor = CKEDITOR.replace('ckeditor');

    // Update live preview on title change
    $('#email-title').on('input', function() {
        $('#preview-title').text($(this).val());
    });

    // Live update the email preview when editor content changes
    editor.on('change', function(evt) {
        $('#preview-body').html(evt.editor.getData());
    });

    // Update footer text in the preview
    $('#footer-text-input').on('input', function() {
        $('#preview-footer').text($(this).val());
    });

    // Update copyright text in the preview
    $('#copyright-text-input').on('input', function() {
        $('#preview-copyright').text($(this).val());
    });

    // Update the preview of social media links
    function updateSocialMediaPreview() {
        $('#preview-social').empty();
        if ($('#facebook').is(':checked')) {
            $('#preview-social').append('<p><a href="#">Facebook</a></p>');
        }
        if ($('#instagram').is(':checked')) {
            $('#preview-social').append('<p><a href="#">Instagram</a></p>');
        }
        if ($('#twitter').is(':checked')) {
            $('#preview-social').append('<p><a href="#">Twitter</a></p>');
        }
        if ($('#linkedin').is(':checked')) {
            $('#preview-social').append('<p><a href="#">LinkedIn</a></p>');
        }
        if ($('#pinterest').is(':checked')) {
            $('#preview-social').append('<p><a href="#">Pinterest</a></p>');
        }
    }

    // Listen for checkbox changes to update preview
    $('input[type=checkbox]').change(function() {
        updateSocialMediaPreview();
    });

    // Initial call to set up preview
    updateSocialMediaPreview();
</script>

@endpush