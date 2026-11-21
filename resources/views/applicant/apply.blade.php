@extends('layouts.app')

@section('title', 'অনলাইন আবেদন ফরম')

@section('content')
            <div class="page-banner">
                <div class="container">
                    <h2>অনলাইন আবেদন ফরম</h2>
                    <p>সকল তারকা (*) চিহ্নিত তথ্য আবশ্যক</p>
                </div>
            </div>
            <div class="container py-4 py-md-5">
                <form id="applyForm" method="POST" action="{{ route('applicant.store') }}" enctype="multipart/form-data"
                    novalidate>
                    @csrf

                    {{-- Server-side errors / flash messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <div class="fw-bold mb-1">আবেদন জমা দেওয়া যায়নি। অনুগ্রহ করে নিচের ভুলগুলো ঠিক করুন:</div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <div class="small mt-2">দ্রষ্টব্য: নিরাপত্তার কারণে ফাইলগুলো আবার নির্বাচন করতে হবে।</div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-warning" role="alert">{{ session('error') }}</div>
                    @endif

                    {{-- 1. Route (area) & category --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip"><svg class="ic">
                                    <use href="#i-pin" />
                                </svg></div>
                            <div>
                                <h3>রুট ও ক্যাটাগরি নির্বাচন</h3><span class="en-sub">Route &amp; Category</span>
                            </div>
                        </div>
                        <div class="card-pad">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-label">রুট<span class="req">*</span></div>
                                    <div class="row g-3">
                                        @foreach ($areas as $area)
                                            <div class="col-12 col-lg-6">
                                                <div class="position-relative h-100">
                                                    <input class="route-input" type="radio" name="area_id"
                                                        id="area{{ $area->id }}" value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'checked' : '' }} required>
                                                    <label class="route-card" for="area{{ $area->id }}">
                                                        <span class="route-badge">{{ $loop->iteration }}</span>
                                                        <span>
                                                            <p class="route-title">{{ $area->area_name }}</p>
                                                        </span>
                                                        <svg class="ic check">
                                                            <use href="#i-check-circle" />
                                                        </svg>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="text-danger small mt-2 d-none" id="routeError"><svg class="ic me-1">
                                            <use href="#i-alert" />
                                        </svg>অনুগ্রহ করে একটি রুট নির্বাচন করুন।</div>
                                    @error('area_id')
                                    <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="category" class="form-label">ক্যাটাগরি<span class="req">*</span></label>
                                    <select id="category" name="category_id" class="form-select" required>
                                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>--
                                            ক্যাটাগরি নির্বাচন করুন --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">ক্যাটাগরি নির্বাচন করুন।</div>
                                    @error('category_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 2. Personal information (name/address fields: Bangla only, enforced by the controller regex)
                    --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip"><svg class="ic">
                                    <use href="#i-user" />
                                </svg></div>
                            <div>
                                <h3>ব্যক্তিগত তথ্য</h3><span class="en-sub">Personal Information</span>
                            </div>
                        </div>
                        <div class="card-pad">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="aName" class="form-label">আবেদনকারীর নাম<span
                                            class="req">*</span></label>
                                    <input type="text" class="form-control" id="aName" name="applicant_name"
                                        value="{{ old('applicant_name') }}" maxlength="255"
                                        placeholder="আপনার পূর্ণ নাম বাংলায় লিখুন" required>
                                    <div class="invalid-feedback">নাম আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                    @error('applicant_name')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="fName" class="form-label">পিতা/স্বামীর নাম<span
                                            class="req">*</span></label>
                                    <input type="text" class="form-control" id="fName" name="guardian_name"
                                        value="{{ old('guardian_name') }}" maxlength="255"
                                        placeholder="পিতা বা স্বামীর নাম বাংলায় লিখুন" required>
                                    <div class="invalid-feedback">পিতা/স্বামীর নাম আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                    @error('guardian_name')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="presentAddr" class="form-label">বর্তমান ঠিকানা<span
                                            class="req">*</span></label>
                                    <textarea class="form-control" id="presentAddr" name="present_address" rows="2"
                                        maxlength="255" placeholder="বাসা/হোল্ডিং, এলাকা, থানা"
                                        required>{{ old('present_address') }}</textarea>
                                    <div class="invalid-feedback">বর্তমান ঠিকানা আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                    @error('present_address')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="permAddr" class="form-label">স্থায়ী ঠিকানা<span
                                            class="req">*</span></label>
                                    <textarea class="form-control" id="permAddr" name="permanent_address" rows="2"
                                        maxlength="255" placeholder="গ্রাম/মহল্লা, ডাকঘর, উপজেলা, জেলা"
                                        required>{{ old('permanent_address') }}</textarea>
                                    <div class="invalid-feedback">স্থায়ী ঠিকানা আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                    @error('permanent_address')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="nid" class="form-label">এনআইডি/জন্মনিবন্ধন নং<span
                                            class="req">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><svg class="ic">
                                                <use href="#i-card" />
                                            </svg></span>
                                        <input type="text" class="form-control en" id="nid" name="nid_no"
                                            value="{{ old('nid_no') }}" maxlength="50" inputmode="numeric"
                                            placeholder="10 / 13 / 17 digit" required>
                                    </div>
                                    @error('nid_no')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="mobile" class="form-label">মোবাইল<span class="req">*</span></label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><svg class="ic">
                                                <use href="#i-phone" />
                                            </svg></span>
                                        {{-- English or Bangla digits, 10-11 long (the controller converts Bangla digits
                                        with Helper::bn2en) --}}
                                        <input type="tel" class="form-control en" id="mobile" name="phone"
                                            value="{{ old('phone') }}" maxlength="11" inputmode="numeric"
                                            placeholder="01XXXXXXXXX" pattern="[0-9০-৯]{10,11}" required>
                                        <div class="invalid-feedback">মোবাইল নম্বর ১০ বা ১১ ডিজিটের হতে হবে।</div>
                                    </div>
                                    @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="email" class="form-label">ইমেইল <span
                                            class="text-muted small fw-normal">(ঐচ্ছিক)</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><svg class="ic">
                                                <use href="#i-mail" />
                                            </svg></span>
                                        <input type="email" class="form-control en" id="email" name="email"
                                            value="{{ old('email') }}" maxlength="255" placeholder="name@example.com">
                                    </div>
                                    @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 3. Documents (max 10 MB each, jpg/jpeg/png/pdf) --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip"><svg class="ic">
                                    <use href="#i-upload" />
                                </svg></div>
                            <div>
                                <h3>প্রয়োজনীয় ডকুমেন্ট সংযুক্তকরণ</h3><span class="en-sub">Document Uploads</span>
                            </div>
                        </div>
                        <div class="card-pad">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="applicant_image"
                                            accept=".jpg,.jpeg,.png,.pdf" data-upload required>
                                        <svg class="ic u-icon">
                                            <use href="#i-camera" />
                                        </svg><span class="u-label">আবেদনকারীর ছবি<span class="req">*</span></span><span
                                            class="u-hint">JPG / PNG / PDF • সর্বোচ্চ 10MB</span><span
                                            class="u-file"></span></label>
                                    @error('applicant_image')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="citizen_certificate_image"
                                            accept=".jpg,.jpeg,.png,.pdf" data-upload required>
                                        <svg class="ic u-icon">
                                            <use href="#i-receipt" />
                                        </svg><span class="u-label">নাগরিকত্ব সনদ / ইউটিলিটি বিল কপি<span
                                                class="req">*</span></span><span class="u-hint">নাগরিক সনদ/বাসা ভাড়ার
                                            চুক্তিপত্র/বাড়ীর মালিকের প্রত্যয়ন/গ্যাস, পানি বা বিদ্যুৎ বিল • সর্বোচ্চ
                                            10MB</span><span class="u-file"></span></label>
                                    @error('citizen_certificate_image')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="category_proof_image"
                                            accept=".jpg,.jpeg,.png,.pdf" data-upload required>
                                        <svg class="ic u-icon">
                                            <use href="#i-badge" />
                                        </svg><span class="u-label">ক্যাটাগরি প্রমানক<span
                                                class="req">*</span></span><span class="u-hint">JPG / PNG / PDF •
                                            সর্বোচ্চ 10MB</span><span class="u-file"></span></label>
                                    @error('category_proof_image')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="nid_image"
                                            accept=".jpg,.jpeg,.png,.pdf" data-upload required>
                                        <svg class="ic u-icon">
                                            <use href="#i-card" />
                                        </svg><span class="u-label">এনআইডি<span class="req">*</span></span><span
                                            class="u-hint">সামনে ও পেছনের পাতা • সর্বোচ্চ 10MB</span><span
                                            class="u-file"></span></label>
                                    @error('nid_image')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 4. Application fee (payment starts after the form is stored: JanataPayService::startPayment)
                    --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip gold"><svg class="ic">
                                    <use href="#i-wallet" />
                                </svg></div>
                            <div>
                                <h3>আবেদন ফি প্রদান</h3><span class="en-sub">Application Fee Payment</span>
                            </div>
                        </div>
                        <div class="card-pad">
                            <div class="fee-summary">
                                <div class="row align-items-center g-3">
                                    <div class="col-12 col-md-7">
                                        <p class="mb-1 text-muted fw-semibold">আবেদন ফি (এককালীন, অফেরতযোগ্য)</p>
                                        <div class="fee-amount">{{ $app_setting->application_fee ?? 200 }}<small
                                                class="fs-4">/- টাকা</small></div>
                                        <p class="secure-note mt-2 mb-0"><svg class="ic text-success me-1">
                                                <use href="#i-shield" />
                                            </svg>জমা দেওয়ার পর আপনাকে নিরাপদ পেমেন্ট গেটওয়েতে নিয়ে যাওয়া হবে</p>
                                    </div>
                                    <div class="col-12 col-md-5 text-md-end">
                                        <button type="submit" class="btn btn-gold btn-lg-cta w-100"
                                            id="applySubmitBtn"><svg class="ic">
                                                <use href="#i-lock" />
                                            </svg><span>Submit &amp; Pay via Payment Gateway</span></button>
                                    </div>
                                </div>
                            </div>
                            {{-- No "name" on purpose: this checkbox is only checked in the browser, it is not sent to
                            the controller --}}
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="declare" required>
                                <label class="form-check-label" for="declare">আমি ঘোষণা করছি যে উপরোক্ত তথ্যসমূহ সত্য ও
                                    নির্ভুল।</label>
                            </div>
                        </div>
                    </section>

                    <div class="text-center">
                        <a href="{{ route('home') }}" class="btn btn-outline-green"><svg class="ic">
                                <use href="#i-arrow-left" />
                            </svg>ফিরে যান</a>
                    </div>
                </form>
            </div>
@endsection

@push('scripts')
<script>
(function () {
'use strict';
            // ---- 2. File upload name preview ----
            document.querySelectorAll('input[data-upload]').forEach(function (input) {
                var box = input.closest('.upload-box');
                var icon = box.querySelector('.u-icon use');
                var original = icon.getAttribute('href');
                input.addEventListener('change', function () {
                    var label = box.querySelector('.u-file');
                    if (input.files && input.files.length) {
                        label.textContent = input.files[0].name;
                        box.classList.add('has-file');
                        icon.setAttribute('href', '#i-check-circle');
                    } else {
                        label.textContent = '';
                        box.classList.remove('has-file');
                        icon.setAttribute('href', original);
                    }
                });
            });

            // ---- 3. Application form (real submit) ----
            var applyForm  = document.getElementById('applyForm');
            var routeError = document.getElementById('routeError');
            var submitBtn  = document.getElementById('applySubmitBtn');

            // The controller rejects any Latin letters in these four fields (regex), so check it client-side too
            ['applicant_name','guardian_name','present_address','permanent_address'].forEach(function (name) {
            var el = applyForm.elements[name];
            var check = function () {
                el.setCustomValidity(/[A-Za-z]/.test(el.value) ? 'শুধুমাত্র বাংলা অক্ষর ও সংখ্যা লিখুন।' : '');
            };
            el.addEventListener('input', check);
            check();
            });

            applyForm.addEventListener('submit', function (e) {
            var areaChosen = applyForm.querySelector('input[name="area_id"]:checked');
            routeError.classList.toggle('d-none', !!areaChosen);
            applyForm.classList.add('was-validated');

            if (!areaChosen || !applyForm.checkValidity()) {
                e.preventDefault();                       // stop only when invalid
                var firstInvalid = applyForm.querySelector(':invalid');
                if (firstInvalid && areaChosen) firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
            // Valid: let the browser submit normally. Lock the button so a double click can't send it twice.
            submitBtn.disabled = true;
            submitBtn.querySelector('span').textContent = 'অপেক্ষা করুন...';
            });

            applyForm.querySelectorAll('input[name="area_id"]').forEach(function (r) {
            r.addEventListener('change', function () { routeError.classList.add('d-none'); });
            });

            // If the user presses Back from the payment page, unlock the button again
            window.addEventListener('pageshow', function (ev) {
            if (ev.persisted) {
                submitBtn.disabled = false;
                submitBtn.querySelector('span').textContent = 'Submit & Pay via Payment Gateway';
            }
            });
})();
</script>
@endpush
