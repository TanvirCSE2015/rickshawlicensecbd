@extends('layouts.app')

@section('title', 'আবেদনের অবস্থা ও ফি প্রদান')

@section('content')
<div id="statusPane">
            <div class="page-banner">
                <div class="container">
                    <h2>আবেদনের অবস্থা ও ফি প্রদান</h2>
                    <p>NID ও মোবাইল নম্বর দিয়ে আপনার আবেদনের অবস্থা, বার্ষিক ফি ও পেমেন্ট ইতিহাস দেখুন</p>
                </div>
            </div>
            <div class="container py-4 py-md-5">

                <section class="app-card mb-4">
                    <div class="card-head">
                        <div class="icon-chip"><svg class="ic">
                                <use href="#i-search" />
                            </svg></div>
                        <div>
                            <h3>আবেদনের অবস্থা অনুসন্ধান করুন</h3><span class="en-sub">Track Application Status</span>
                        </div>
                    </div>
                    <div class="card-pad">
                        <form id="searchForm" class="row g-3 align-items-end" action="{{ route('applicant.search') }}" method="POST" novalidate>
                            @csrf
                            <div class="col-12 col-md-9">
                                <label for="sSearch" class="form-label">এনআইডি অথবা মোবাইল নম্বর</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><svg class="ic"><use href="#i-search" /></svg></span>
                                    <input type="text" class="form-control en" id="sSearch" name="search"
                                        inputmode="numeric" maxlength="17" autocomplete="off"
                                        placeholder="NID বা 01XXXXXXXXX" required>
                                    <div class="invalid-feedback">সঠিক এনআইডি বা মোবাইল নম্বর দিন (শুধু সংখ্যা, ১০–১৭ ডিজিট)।</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-green flex-grow-1" id="searchBtn">
                                    <svg class="ic"><use href="#i-search" /></svg><span>অনুসন্ধান</span>
                                </button>
                                <button type="button" class="btn btn-outline-green" id="resetSearch" title="রিসেট" aria-label="রিসেট">
                                    <svg class="ic"><use href="#i-reset" /></svg>
                                </button>
                            </div>
                        </form>

                        <div id="searchError" class="alert alert-warning mt-3 d-none" role="alert"></div>
                    </div>
                </section>

                <div id="saveNotice" class="alert alert-success d-none d-flex align-items-center gap-2" role="status">
                    <svg class="ic">
                        <use href="#i-check-circle" />
                    </svg><span>আপনার আবেদনের পরিবর্তন সফলভাবে সংরক্ষিত হয়েছে।</span>
                </div>

                <div id="resultView" class="d-none fade-in">

                    

                </div><!-- /resultView -->

                <div class="text-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-green"><svg class="ic">
                            <use href="#i-arrow-left" />
                        </svg>ফিরে যান</a>
                </div>
            </div>
</div>

<div id="editPane" class="d-none">
            <div class="page-banner">
                <div class="container">
                    <h2>আবেদন সম্পাদনা</h2>
                    <p class="en">Application ID: DCB-RK-2026-004217</p>
                </div>
            </div>
            <div class="container py-4 py-md-5">
                <div class="edit-notice mb-4">
                    <svg class="ic mt-1">
                        <use href="#i-info" />
                    </svg>
                    <div>আপনি আপনার জমা দেওয়া আবেদনের তথ্য পরিবর্তন করছেন। <strong>এনআইডি নম্বর পরিবর্তন করা যাবে
                            না।</strong> নতুন ডকুমেন্ট না দিলে আগের ডকুমেন্টই থাকবে।</div>
                </div>

                <form id="editForm" method="POST" action="#" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')   {{-- must match the verb of the applicant.update route; delete this line if it is Route::post --}}
                    <input type="hidden" name="current_nid" value="">

                    <div id="editErrors" class="alert alert-danger d-none" role="alert"></div>

                    {{-- Route & category --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip"><svg class="ic"><use href="#i-pin" /></svg></div>
                            <div><h3>রুট ও ক্যাটাগরি</h3><span class="en-sub">Route &amp; Category</span></div>
                        </div>
                        <div class="card-pad">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-label">রুট<span class="req">*</span></div>
                                    <div class="row g-3">
                                        @foreach ($areas as $area)
                                            <div class="col-12 col-lg-6">
                                                <div class="position-relative h-100">
                                                    <input class="route-input" type="radio" name="area_id" id="eArea{{ $area->id }}"
                                                        value="{{ $area->id }}" required>
                                                    <label class="route-card" for="eArea{{ $area->id }}">
                                                        <span class="route-badge">{{ $loop->iteration }}</span>
                                                        <span><p class="route-title">{{ $area->area_name }}</p></span>
                                                        <svg class="ic check"><use href="#i-check-circle" /></svg>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="text-danger small mt-2 d-none" id="eRouteError">
                                        <svg class="ic me-1"><use href="#i-alert" /></svg>অনুগ্রহ করে একটি রুট নির্বাচন করুন।
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="eCategory" class="form-label">ক্যাটাগরি<span class="req">*</span></label>
                                    <select id="eCategory" name="category_id" class="form-select" required>
                                        <option value="" disabled>-- ক্যাটাগরি নির্বাচন করুন --</option>
                                        {{-- $editCategories = all categories (see note in the answer); falls back to $categories --}}
                                        @foreach (($editCategories ?? $categories) as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">ক্যাটাগরি নির্বাচন করুন।</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Personal information --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip"><svg class="ic"><use href="#i-user" /></svg></div>
                            <div><h3>ব্যক্তিগত তথ্য</h3><span class="en-sub">Personal Information</span></div>
                        </div>
                        <div class="card-pad">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="eName" class="form-label">আবেদনকারীর নাম<span class="req">*</span></label>
                                    <input type="text" class="form-control" id="eName" name="applicant_name" maxlength="255" required>
                                    <div class="invalid-feedback">নাম আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="eFather" class="form-label">পিতা/স্বামীর নাম<span class="req">*</span></label>
                                    <input type="text" class="form-control" id="eFather" name="guardian_name" maxlength="255" required>
                                    <div class="invalid-feedback">পিতা/স্বামীর নাম আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="ePresent" class="form-label">বর্তমান ঠিকানা<span class="req">*</span></label>
                                    <textarea class="form-control" id="ePresent" name="present_address" rows="2" maxlength="255" required></textarea>
                                    <div class="invalid-feedback">বর্তমান ঠিকানা আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="ePerm" class="form-label">স্থায়ী ঠিকানা<span class="req">*</span></label>
                                    <textarea class="form-control" id="ePerm" name="permanent_address" rows="2" maxlength="255" required></textarea>
                                    <div class="invalid-feedback">স্থায়ী ঠিকানা আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="eNid" class="form-label">এনআইডি/জন্মনিবন্ধন নং
                                        <span class="text-muted small fw-normal">(পরিবর্তনযোগ্য নয়)</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><svg class="ic"><use href="#i-lock" /></svg></span>
                                        <input type="text" class="form-control en" id="eNid" name="nid_no" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="eMobile" class="form-label">মোবাইল<span class="req">*</span></label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><svg class="ic"><use href="#i-phone" /></svg></span>
                                        <input type="tel" class="form-control en" id="eMobile" name="phone" maxlength="11"
                                            inputmode="numeric" pattern="[0-9০-৯]{10,11}" required>
                                        <div class="invalid-feedback">মোবাইল নম্বর ১০ বা ১১ ডিজিটের হতে হবে।</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="eEmail" class="form-label">ইমেইল <span class="text-muted small fw-normal">(ঐচ্ছিক)</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><svg class="ic"><use href="#i-mail" /></svg></span>
                                        <input type="email" class="form-control en" id="eEmail" name="email" maxlength="255">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Documents (optional: only the files the user picks are sent and replaced) --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip"><svg class="ic"><use href="#i-upload" /></svg></div>
                            <div>
                                <h3>ডকুমেন্ট পরিবর্তন <span class="fs-6 fw-normal text-muted">(ঐচ্ছিক)</span></h3>
                                <span class="en-sub">নতুন ফাইল না দিলে আগের ফাইলই থাকবে</span>
                            </div>
                        </div>
                        <div class="card-pad">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="applicant_image" accept=".jpg,.jpeg,.png,.pdf" data-edit-upload>
                                        <svg class="ic u-icon"><use href="#i-camera" /></svg><span class="u-label">আবেদনকারীর ছবি</span><span class="u-hint">JPG / PNG / PDF • সর্বোচ্চ 10MB</span><span class="u-file"></span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="citizen_certificate_image" accept=".jpg,.jpeg,.png,.pdf" data-edit-upload>
                                        <svg class="ic u-icon"><use href="#i-receipt" /></svg><span class="u-label">নাগরিকত্ব সনদ / ইউটিলিটি বিল কপি</span><span class="u-hint">JPG / PNG / PDF • সর্বোচ্চ 10MB</span><span class="u-file"></span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="category_proof_image" accept=".jpg,.jpeg,.png,.pdf" data-edit-upload>
                                        <svg class="ic u-icon"><use href="#i-badge" /></svg><span class="u-label">ক্যাটাগরি প্রমানক</span><span class="u-hint">JPG / PNG / PDF • সর্বোচ্চ 10MB</span><span class="u-file"></span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="nid_image" accept=".jpg,.jpeg,.png,.pdf" data-edit-upload>
                                        <svg class="ic u-icon"><use href="#i-card" /></svg><span class="u-label">এনআইডি</span><span class="u-hint">সামনে ও পেছনের পাতা • সর্বোচ্চ 10MB</span><span class="u-file"></span></label>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                        <button type="submit" class="btn btn-green btn-lg-cta"><svg class="ic"><use href="#i-check" /></svg>পরিবর্তন সংরক্ষণ করুন</button>
                        <button type="button" class="btn btn-outline-green btn-lg-cta" id="cancelEditBtn"><svg class="ic"><use href="#i-arrow-left" /></svg>বাতিল করুন</button>
                    </div>
                </form>
            </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
'use strict';
            // ---- 4. Search (single field: NID or mobile) ----
            var searchForm  = document.getElementById('searchForm');
            var searchInput = document.getElementById('sSearch');
            var searchBtn   = document.getElementById('searchBtn');
            var searchError = document.getElementById('searchError');
            var resultView  = document.getElementById('resultView');

            function bn2en(s) { return s.replace(/[০-৯]/g, function (d) { return '০১২৩৪৫৬৭৮৯'.indexOf(d); }); }

            searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            searchError.classList.add('d-none');

            var term = bn2en(searchInput.value).replace(/\D+/g, '');
            var ok = /^\d{10,17}$/.test(term);
            searchInput.setCustomValidity(ok ? '' : 'invalid');
            searchForm.classList.add('was-validated');
            if (!ok) return;

            var fd = new FormData(searchForm);          // includes the @csrf token
            fd.set('search', term);

            searchBtn.disabled = true;
            fetch(searchForm.action, {
                method: 'POST',
                body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(function (r) { if (!r.ok) throw new Error(r.status); return r.json(); })
            .then(function (data) {
                if (data.error) {
                resultView.classList.add('d-none');
                searchError.textContent = data.error;
                searchError.classList.remove('d-none');
                return;
                }
                resultView.innerHTML = data.html;          // server-rendered applicant.search view
                resultView.classList.remove('d-none');
                resultView.scrollIntoView({ behavior: 'smooth', block: 'start' });
            })
            .catch(function () {
                searchError.textContent = 'অনুসন্ধান করা যায়নি। অনুগ্রহ করে আবার চেষ্টা করুন।';
                searchError.classList.remove('d-none');
            })
            .finally(function () { searchBtn.disabled = false; });
            });

            searchInput.addEventListener('input', function () { searchInput.setCustomValidity(''); });

            document.getElementById('resetSearch').addEventListener('click', function () {
            searchForm.reset();
            searchForm.classList.remove('was-validated');
            searchError.classList.add('d-none');
            resultView.classList.add('d-none');
            resultView.innerHTML = '';
            });

            // ---- 5. AJAX helpers ----
            var ajaxHeaders = { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' };

            function parseResponse(r) {
                return r.json().catch(function () { return {}; })
                        .then(function (data) { return { ok: r.ok, status: r.status, data: data }; });
            }
            function errorMessages(res) {
                if (res.status === 419) return ['পেজের সেশন শেষ হয়ে গেছে। পেজটি রিফ্রেশ করে আবার চেষ্টা করুন।'];
                if (res.data && res.data.errors) return [].concat.apply([], Object.values(res.data.errors));
                return [(res.data && res.data.message) || 'কিছু একটা সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।'];
            }
            function showAlert(box, msgs) {
                box.textContent = '';
                var ul = document.createElement('ul'); ul.className = 'mb-0 ps-3';
                msgs.forEach(function (m) { var li = document.createElement('li'); li.textContent = m; ul.appendChild(li); });
                box.appendChild(ul);
                box.classList.remove('d-none');
                box.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            var statusPane = document.getElementById('statusPane');
            var editPane   = document.getElementById('editPane');
            function goToStatusTab() {
                editPane.classList.add('d-none');
                statusPane.classList.remove('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            // ---- 6. Yearly fee payment (the form lives inside the AJAX-loaded result) ----
            resultView.addEventListener('submit', function (e) {
                var form = e.target.closest('form[data-ajax]');
                if (!form) return;
                e.preventDefault();

                var box = form.parentElement.querySelector('[data-form-alert]');
                var btn = form.querySelector('button[type=submit]');
                box.classList.add('d-none');
                btn.disabled = true;

                fetch(form.action, { method: 'POST', body: new FormData(form), headers: ajaxHeaders })
                    .then(parseResponse)
                    .then(function (res) {
                        if (res.ok && res.data.redirect) { window.location.href = res.data.redirect; return; }  // stays disabled while leaving
                        showAlert(box, errorMessages(res));
                        btn.disabled = false;
                    })
                    .catch(function () {
                        showAlert(box, ['নেটওয়ার্ক সমস্যা। অনুগ্রহ করে আবার চেষ্টা করুন।']);
                        btn.disabled = false;
                    });
            });

            // If the user comes Back from the payment page, unlock the button
            window.addEventListener('pageshow', function (ev) {
                if (ev.persisted) {
                    resultView.querySelectorAll('form[data-ajax] button[type=submit]').forEach(function (b) { b.disabled = false; });
                }
            });
            // ---- 7. Edit application ----
            var editForm    = document.getElementById('editForm');
            var editErrors  = document.getElementById('editErrors');
            var saveNotice  = document.getElementById('saveNotice');
            var eRouteError = document.getElementById('eRouteError');      // optional

            // Open the edit tab and fill it from the button's data
            resultView.addEventListener('click', function (e) {
                var btn = e.target.closest('#editAppBtn');
                if (!btn) return;

                var d = JSON.parse(btn.getAttribute('data-applicant'));
                editForm.action = btn.getAttribute('data-update-url');
                if (editForm.elements['current_nid']) editForm.elements['current_nid'].value = d.nid_no;
                editForm.classList.remove('was-validated');
                editErrors.classList.add('d-none');
                if (eRouteError) eRouteError.classList.add('d-none');

                ['applicant_name', 'guardian_name', 'present_address', 'permanent_address',
                'nid_no', 'phone', 'email', 'category_id'].forEach(function (n) {
                    var el = editForm.elements[n];
                    if (el) el.value = d[n] == null ? '' : d[n];
                });
                var radio = editForm.querySelector('input[name="area_id"][value="' + d.area_id + '"]');
                if (radio) radio.checked = true;

                editForm.querySelectorAll('input[data-edit-upload]').forEach(function (inp) {
                    inp.value = '';
                    var box = inp.closest('.upload-box');
                    box.classList.remove('has-file');
                    box.querySelector('.u-file').textContent = '';
                });

                saveNotice.classList.add('d-none');
                statusPane.classList.add('d-none');
                editPane.classList.remove('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            document.getElementById('cancelEditBtn').addEventListener('click', goToStatusTab);

            // Show the chosen replacement file name
            editForm.querySelectorAll('input[data-edit-upload]').forEach(function (inp) {
                inp.addEventListener('change', function () {
                    var box = inp.closest('.upload-box');
                    var label = box.querySelector('.u-file');
                    var has = inp.files && inp.files.length;
                    label.textContent = has ? inp.files[0].name : '';
                    box.classList.toggle('has-file', !!has);
                });
            });

            // Save
            editForm.addEventListener('submit', function (e) {
                e.preventDefault();
                editErrors.classList.add('d-none');
                editForm.classList.add('was-validated');

                var areaChosen = editForm.querySelector('input[name="area_id"]:checked');
                if (eRouteError) eRouteError.classList.toggle('d-none', !!areaChosen);
                if (!areaChosen || !editForm.checkValidity()) {
                    var bad = editForm.querySelector(':invalid');
                    if (bad) bad.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }

                var btn = editForm.querySelector('button[type=submit]');
                btn.disabled = true;

                fetch(editForm.action, { method: 'POST', body: new FormData(editForm), headers: ajaxHeaders })   // _method=PUT is inside the form data
                    .then(parseResponse)
                    .then(function (res) {
                        if (!res.ok) { showAlert(editErrors, errorMessages(res)); return; }   // stays on the edit tab

                        goToStatusTab();
                        saveNotice.classList.remove('d-none');
                        if (res.data.nid_no) searchInput.value = res.data.nid_no;
                        searchForm.dispatchEvent(new Event('submit', { cancelable: true }));   // reload the result with fresh data
                    })
                    .catch(function () { showAlert(editErrors, ['নেটওয়ার্ক সমস্যা। অনুগ্রহ করে আবার চেষ্টা করুন।']); })
                    .finally(function () { btn.disabled = false; });
            });
})();
</script>
@endpush
