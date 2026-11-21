<section class="app-card mb-4">
    <div class="card-head">
        <div class="icon-chip"><svg class="ic">
                <use href="#i-user" />
            </svg></div>
        <div>
            <h3>আবেদনকারীর তথ্য</h3><span class="en-sub">Applicant Summary</span>
        </div>
        <div class="ms-auto d-flex align-items-center gap-2 flex-wrap justify-content-end">
            <a href="{{ route('applicant.print', ['id' => $applicant->id]) }}" class="btn btn-gold btn-sm" target="_blank">
                প্রিন্ট করুন
            </a>
            @if(($applicant->status=='pending' || $applicant->status=='rejected') && \Carbon\Carbon::parse($settings->app_expire_date)->greaterThanOrEqualTo(today()))
            <!-- Show this button only if the application is still editable (see canEdit in the script) -->
            <button type="button" class="btn btn-outline-green btn-sm" id="editAppBtn" data-update-url="{{ route('applicant.update', $applicant->id) }}" data-applicant="{{ json_encode($applicant->only([
        'area_id','category_id','applicant_name','guardian_name',
        'present_address','permanent_address','nid_no','phone','email'
    ]), JSON_UNESCAPED_UNICODE) }}"><svg class="ic">
                    <use href="#i-edit" />
                </svg>আবেদন সম্পাদনা করুন</button>
            @endif
        </div>
    </div>
    <div class="card-pad">
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="avatar"><svg class="ic">
                    <use href="#i-user" />
                </svg></div>
            <div>
                <h4 class="mb-0 fs-5 fw-bold" id="sumName">{{ $applicant->applicant_name }}</h4><span
                    class="text-muted small en">Application Number: {{ $applicant->application_number }}</span>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-6 col-md-3 info-item">
                <p class="k">পিতা/স্বামীর নাম</p>
                <p class="v" id="sumFather">{{ $applicant->guardian_name }}</p>
            </div>
            <div class="col-6 col-md-3 info-item">
                <p class="k">বর্তমান ঠিকানা</p>
                <p class="v en">{{ $applicant->present_address }}</p>
            </div>
            <div class="col-6 col-md-3 info-item">
                <p class="k">স্থায়ী ঠিকানা</p>
                <p class="v en">{{ $applicant->permanent_address }}</p>
            </div>
            <div class="col-6 col-md-3 info-item">
                <p class="k">NID</p>
                <p class="v en">{{ $applicant->nid_no }}</p>
            </div>
            <div class="col-6 col-md-3 info-item">
                <p class="k">মোবাইল</p>
                <p class="v en">{{ $applicant->phone }}</p>
            </div>
            <div class="col-6 col-md-3 info-item">
                <p class="k">ইমেইল</p>
                <p class="v en">{{ $applicant->email ?? '—' }}</p>
            </div>
            <div class="col-12 col-md-6 info-item">
                <p class="k">রুট</p>
                <p class="v" id="sumRoute">{{ $applicant->area?->area_name }}
                </p>
            </div>
            <div class="col-12 col-md-6 info-item">
                <p class="k">ক্যাটাগরি</p>
                <p class="v" id="sumCategory">{{ $applicant->category?->category_name }}</p>
            </div>
            <div class="col-12 col-md-6 info-item">
                @php
                $statuses = [
                    'pending'    => ['text' => 'অপেক্ষমাণ',     'class' => 'badge-pending',    'icon' => 'i-hourglass'],
                    'confirmed'  => ['text' => 'গৃহীত হয়েছে',   'class' => 'badge-confirmed',  'icon' => 'i-check'],
                    'approved'   => ['text' => 'অনুমোদিত',      'class' => 'badge-approved',   'icon' => 'i-check-circle'],
                    'selected'   => ['text' => 'নির্বাচিত',      'class' => 'badge-selected',   'icon' => 'i-badge'],
                    'rejected'   => ['text' => 'বাতিল',          'class' => 'badge-rejected',   'icon' => 'i-x-circle'],
                    'expired'    => ['text' => 'মেয়াদোত্তীর্ণ', 'class' => 'badge-expired',    'icon' => 'i-clock'],
                    'unselected' => ['text' => 'অনির্বাচিত',     'class' => 'badge-unselected', 'icon' => 'i-minus-circle'],
                ];

                $currentStatus = strtolower($applicant->status ?? 'pending');
                $s = $statuses[$currentStatus] ?? $statuses['pending'];   // unknown status falls back to pending
                @endphp
                <p class="k">আবেদনের অবস্থা</p>
                <p class="v"><span class="{{ $s['class'] }}"><svg class="ic">
                            <use href="#{{ $s['icon'] }}" />
                        </svg>{{ $s['text'] }}</span></p>
            </div>
        </div>
    </div>
</section>
@if ($applicant->status === 'approved' && !$yearlyFeePaid)
<!-- Yearly fee box: enabled when Approved -->
<section class="app-card mb-4" id="yearlyFeeBox">
    <div class="card-head">
        <div class="icon-chip gold"><svg class="ic">
                <use href="#i-cash" />
            </svg></div>
        <div>
            <h3>বার্ষিক ও নিরাপত্তা ফি প্রদান</h3><span class="en-sub">Yearly and Security Fee
                Payment</span>
        </div>
        <div class="ms-auto d-none d-sm-block"><span class="badge-approved"><svg class="ic">
                    <use href="#i-unlock" />
                </svg>পেমেন্ট উন্মুক্ত</span></div>
    </div>
    <div class="card-pad">
        <div class="row g-4">
            @php
                $yearlyFee = $settings->yearly_fee ?? 0;
                $securityFee = $settings->security_fee ?? 0;
                $taxPercent = $settings->tax_percent ?? 0;

                $subtotal = $yearlyFee + $securityFee;
                $vatAmount = ($subtotal * $taxPercent) / 100;
                $totalAmount = $subtotal + $vatAmount;
            @endphp
            <div class="col-12 col-lg-7">
                <div class="fee-row"><span>বার্ষিক ফি</span><span class="amt">{{ number_format($yearlyFee, 2) }}/-</span></div>
                <div class="fee-row"><span>নিরাপত্তা ফি</span><span class="amt">{{ number_format($securityFee, 2) }}/-</span></div>
                <div class="fee-row"><span>{{ $taxPercent }}% ভ্যাট</span><span class="amt">{{ number_format($vatAmount, 2) }}/-</span></div>
                <div class="fee-total"><span class="fw-semibold">সর্বমোট প্রদেয়</span><span class="amt">৳
                        {{ number_format($totalAmount, 2) }}/-</span></div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="fee-summary h-100 d-flex flex-column justify-content-center text-center">
                    <p class="mb-3 fw-semibold">আপনার আবেদন অনুমোদিত হয়েছে। লাইসেন্স সক্রিয় করতে
                        বার্ষিক ও নিরাপত্তা ফি ভ্যাট সহ পরিশোধ করুন।</p>
                    <!-- <button type="button" class="btn btn-gold btn-lg-cta w-100" id="payYearlyBtn"><svg class="ic">
                            <use href="#i-lock" />
                        </svg>পরিশোধ করুন</button> -->
                    <form method="POST" action="{{ route('applicant.yearly-fee.payment', $applicant->id) }}" data-ajax>
                        @csrf
                        <button type="submit" class="btn btn-gold btn-lg-cta w-100" id="payYearlyBtn">
                            <svg class="ic"><use href="#i-lock" /></svg><span>পরিশোধ করুন</span>
                        </button>
                    </form>
                    <div class="alert alert-danger text-start mt-3 mb-0 d-none" data-form-alert role="alert"></div>
                    <p class="secure-note mt-2 mb-0"><svg class="ic text-success me-1">
                            <use href="#i-shield" />
                        </svg>জনতা পেমেন্ট গেটওয়ে</p>
                </div>
            </div>
        </div>
    </div>
</section>
@else
 <!-- LOCKED / DISABLED STATE (use when status is Pending) -->
<section class="app-card mb-4 fee-locked" id="yearlyFeeBox">
    <div class="card-head">
    <div class="icon-chip"><svg class="ic"><use href="#i-lock"/></svg></div>
    <div><h3>বার্ষিক লাইসেন্স ফি প্রদান</h3><span class="en-sub">Yearly License Fee Payment</span></div>
    <div class="ms-auto"><span class="badge-pending"><svg class="ic"><use href="#i-hourglass"/></svg>অপেক্ষমান</span></div>
    </div>
    <div class="card-pad text-center">
    <svg class="ic ic-lg text-muted"><use href="#i-lock"/></svg>
    <p class="fw-semibold mt-2 mb-1">বার্ষিক ফি প্রদান এখনো সক্রিয় নয়</p>
    <p class="text-muted mb-3">আপনার আবেদন অনুমোদিত হওয়ার পর এই অপশনটি চালু হবে।</p>
    <button type="button" class="btn btn-gold btn-lg-cta" disabled aria-disabled="true"><svg class="ic"><use href="#i-lock"/></svg>Pay Yearly License Fee Now</button>
    </div>
</section>
@endif
@if ($paymentInfo)
<section class="app-card mb-4">
    <div class="card-head">
        <div class="icon-chip"><svg class="ic">
                <use href="#i-history" />
            </svg></div>
        <div>
            <h3>পেমেন্ট ইতিহাস</h3><span class="en-sub">Payment History</span>
        </div>
    </div>
    <div class="card-pad">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>পেমেন্টের ধরন</th>
                        <th>তারিখ</th>
                        <th class="text-end">পরিমাণ (BDT)</th>
                        <th>অবস্থা</th>
                        <th class="text-center">রশিদ</th>
                    </tr>
                </thead>
                <tbody>
                    @if($applicationFeePaid)
                    <tr>
                        <td class="txn-id">{{ $paymentInfo->applicationFee?->gateway_transaction_id }}</td>
                        <td>আবেদন ফি</td>
                        <td class="en">
                        {{ $paymentInfo->applicationFee?->fee_date
                        ? \Carbon\Carbon::parse($paymentInfo->applicationFee->fee_date)->format('d M Y')
                        : '' }}
                        </td>
                        <td class="text-end en fw-semibold">{{ $paymentInfo->applicationFee?->amount ?? 0 }}</td>
                        <td><span class="status-paid"><svg class="ic">
                                    <use href="#i-check-circle" />
                                </svg>Paid</span></td>
                        <td class="text-center"><button class="btn btn-sm btn-outline-green"
                                data-receipt="TXN-20260412-88421"><svg class="ic">
                                    <use href="#i-download" />
                                </svg>রশিদ</button></td>
                    </tr>
                    @endif
                    @if($yearlyFeePaid)
                    <tr>
                        <td class="txn-id">{{ $paymentInfo->yearlyFee?->gateway_transaction_id }}</td>
                        <td>বার্ষিক ফি,নিরাপত্তা ফি এবং ট্যাক্স</td>
                        <td class="en">
                        {{ $paymentInfo->yearlyFee?->fee_date
                        ? \Carbon\Carbon::parse($paymentInfo->yearlyFee->fee_date)->format('d M Y')
                        : '' }}
                        </td>
                        <td class="text-end en fw-semibold">
                            {{ $paymentInfo->yearlyFee?->amount +  $paymentInfo->securityFee?->amount + $paymentInfo->tax }}
                        </td>
                        <td><span class="status-paid"><svg class="ic">
                                    <use href="#i-check-circle" />
                                </svg>Paid</span></td>
                        <td class="text-center"><button class="btn btn-sm btn-outline-green"
                                data-receipt="TXN-20260603-10977"><svg class="ic">
                                    <use href="#i-download" />
                                </svg>রশিদ</button></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>
@endif