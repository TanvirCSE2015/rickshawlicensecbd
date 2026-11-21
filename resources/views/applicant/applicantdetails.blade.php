@extends('layouts.app')
@section('content')
@php
    function en2bn($number)
    {
        $en = ['0','1','2','3','4','5','6','7','8','9','January','February','March','April','May','June','July','August','September','October','November','December'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯','জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];
        

        return str_replace($en, $bn, $number);
    }
@endphp
    <div class="card shadow border-0 rounded-4 mb-5" style="background: white;" id="applicantFormCard">
        <div class="card-header">
            <h3 class="text-center fw-bold">বিস্তারিত তথ্য</h3>
        </div>
        <div class="card-body">
            <div class="container mt-2">
                <div class="text-center">
                  
                    <div class="my-2 " id="applicant_preview_box" >
                              @php
                                    $filePath = $applicant->applicant_image;
                                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                    $pdf_display = $extension=='pdf'?'':'display:none;';
                                    $img_display = $extension!='pdf'?'':'display:none;';
                                @endphp
                            <img 
                                src="{{ asset('storage/'.$filePath) }}" 
                                alt="Applicant Image" 
                                class="img-thumbnail shadow"
                                width="150"
                                style="{{ $img_display }}" 
                                id="applicant_image_preview">
                    </div>
                </div>
                <div class="row justify-content-center mt-3 mb-5">
                    <div class="col-md-6 shadow">
                        <table class="table table-bordered table-striped border-black">
                            <tbody>
                                <tr>
                                    <td>লাইসেন্স নাম্বার</td>
                                    <td>{{ en2bn($applicant->license_number) }}</td>
                                </tr>
                                <tr>
                                    <td>রুট</td>
                                    <td>{{ 'রুট নং-' . en2bn($applicant->area_id)  }}</td>
                                </tr>
                                <tr>
                                    <td>ক্যাটাগরি</td>
                                    <td>{{ $applicant->category->category_name }}</td>
                                </tr>
                                <tr>
                                    <td>নাম</td>
                                    <td>{{ $applicant->applicant_name }}</td>
                                </tr>
                                <tr>
                                    <td>পিতার নাম</td>
                                    <td>{{ $applicant->guardian_name }}</td>
                                </tr>
                                <tr>
                                    <td>এন আই ডি </td>
                                    <td>{{ $applicant->nid_no }}</td>
                                </tr>
                                <tr>
                                    <td>মোবাইল</td>
                                    <td>{{ $applicant->phone }}</td>
                                </tr>
                                <tr>
                                    <td>বর্তমান ঠিকানা</td>
                                    <td>{{ $applicant->present_address }}</td>
                                </tr>
                                
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // image preview
        document.getElementById('applicant_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('applicant_preview_box').style.display = 'block';
                if (file.type.startsWith("image/")) {
                    document.getElementById('applicant_image_preview').style.display = "block";
                    document.getElementById('applicant_pdf_preview').style.display = "none";
                    document.getElementById('applicant_image_preview').src = URL.createObjectURL(file);
                }else if (file.type === "application/pdf") {
                    document.getElementById('applicant_image_preview').style.display = "none";
                    document.getElementById('applicant_pdf_preview').style.display = "block";
                    document.getElementById('applicant_pdf_preview').src = URL.createObjectURL(file);
                }
                //document.getElementById('applicant_image_preview').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('citizen_certificate_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('citizen_preview_box').style.display = 'block';
                if (file.type.startsWith("image/")) {
                    document.getElementById('citizen_image_preview').style.display = "block";
                    document.getElementById('citizen_pdf_preview').style.display = "none";
                    document.getElementById('citizen_image_preview').src = URL.createObjectURL(file);
                }else if (file.type === "application/pdf") {
                    document.getElementById('citizen_image_preview').style.display = "none";
                    document.getElementById('citizen_pdf_preview').style.display = "block";
                    document.getElementById('citizen_pdf_preview').src = URL.createObjectURL(file);
                }
                //document.getElementById('citizen_image_preview').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('category_proof_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('category_preview_box').style.display = 'block';
                if (file.type.startsWith("image/")) {
                    document.getElementById('category_image_preview').style.display = "block";
                    document.getElementById('category_pdf_preview').style.display = "none";
                    document.getElementById('category_image_preview').src = URL.createObjectURL(file);
                }else if (file.type === "application/pdf") {
                    document.getElementById('category_image_preview').style.display = "none";
                    document.getElementById('category_pdf_preview').style.display = "block";
                    document.getElementById('category_pdf_preview').src = URL.createObjectURL(file);
                }
                //document.getElementById('category_image_preview').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('nid_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('nid_preview_box').style.display = 'block';
                if (file.type.startsWith("image/")) {
                    document.getElementById('nid_image_preview').style.display = "block";
                    document.getElementById('nid_pdf_preview').style.display = "none";
                    document.getElementById('nid_image_preview').src = URL.createObjectURL(file);
                }else if (file.type === "application/pdf") {
                    document.getElementById('nid_image_preview').style.display = "none";
                    document.getElementById('nid_pdf_preview').style.display = "block";
                    document.getElementById('nid_pdf_preview').src = URL.createObjectURL(file);
                }
                //document.getElementById('nid_image_preview').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('py_order_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('pay_order_preview_box').style.display = 'block';
                if (file.type.startsWith("image/")) {
                    document.getElementById('pay_order_image_preview').style.display = "block";
                    document.getElementById('pay_order_pdf_preview').style.display = "none";
                    document.getElementById('pay_order_image_preview').src = URL.createObjectURL(file);
                }else if (file.type === "application/pdf") {
                    document.getElementById('pay_order_image_preview').style.display = "none";
                    document.getElementById('pay_order_pdf_preview').style.display = "block";
                    document.getElementById('pay_order_pdf_preview').src = URL.createObjectURL(file);
                }
                //document.getElementById('pay_order_image_preview').src = URL.createObjectURL(file);
            }
        });
    </script>
    @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let firstError = document.querySelector('.is-invalid');

            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    </script>
    @endif
@endsection