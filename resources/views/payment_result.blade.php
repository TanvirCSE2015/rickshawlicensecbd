@extends('layouts.app')

@section('title', 'পেমেন্টের ফলাফল')

@php
    // $status is whitelisted in the controller: success | failed | cancelled | pending | invalid
    $states = [
        'success' => [
            'icon' => 'i-check-circle', 'color' => '#0A5C36', 'bg' => '#E6F2EB',
            'title' => 'পেমেন্ট সফল হয়েছে',
            'text'  => 'আপনার পেমেন্ট সফলভাবে সম্পন্ন হয়েছে। আবেদনের অবস্থা ও রসিদ দেখতে আবেদনের অবস্থা পেজে যান।',
        ],
        'failed' => [
            'icon' => 'i-alert', 'color' => '#B91C1C', 'bg' => '#FDECEC',
            'title' => 'পেমেন্ট ব্যর্থ হয়েছে',
            'text'  => 'দুঃখিত, আপনার পেমেন্ট সম্পন্ন হয়নি। আপনার একাউন্ট থেকে টাকা কাটা হয়ে থাকলে তা স্বয়ংক্রিয়ভাবে ফেরত আসবে। অনুগ্রহ করে নতুন করে আবেদন করুন।',
        ],
        'cancelled' => [
            'icon' => 'i-alert', 'color' => '#B45309', 'bg' => '#FEF3E2',
            'title' => 'পেমেন্ট বাতিল করা হয়েছে',
            'text'  => 'আপনি পেমেন্ট বাতিল করেছেন। কোনো টাকা কাটা হয়নি। প্রয়োজনে নতুন করে আবেদন করুন।',
        ],
        'pending' => [
            'icon' => 'i-info', 'color' => '#1D4ED8', 'bg' => '#E8F0FE',
            'title' => 'পেমেন্ট যাচাই চলছে',
            'text'  => 'আপনার পেমেন্টের তথ্য যাচাই করা হচ্ছে। কিছুক্ষণ পর আবেদনের অবস্থা পেজ থেকে NID বা মোবাইল নম্বর দিয়ে অবস্থা দেখুন। টাকা কাটা হয়ে থাকলে পুনরায় পেমেন্ট করবেন না।',
        ],
        'invalid' => [
            'icon' => 'i-info', 'color' => '#4B5563', 'bg' => '#F3F4F6',
            'title' => 'অবৈধ অনুরোধ',
            'text'  => 'পেমেন্টের তথ্য পাওয়া যায়নি। অনুগ্রহ করে আবার চেষ্টা করুন।',
        ],
    ];
    $s = $states[$status] ?? $states['invalid'];
    $retry = in_array($status, ['failed', 'cancelled', 'invalid']);
@endphp

@section('content')
<div class="page-banner">
    <div class="container">
        <h2>পেমেন্টের ফলাফল</h2>
        <p>Payment Result</p>
    </div>
</div>

<div class="container py-4 py-md-5">
    <section class="app-card mx-auto text-center" style="max-width:640px">
        <div class="card-pad py-5">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                 style="width:84px;height:84px;background:{{ $s['bg'] }};color:{{ $s['color'] }}">
                <svg class="ic" style="width:44px;height:44px"><use href="#{{ $s['icon'] }}" /></svg>
            </div>

            <h3 class="mb-2" style="color:{{ $s['color'] }}">{{ $s['title'] }}</h3>
            <p class="text-muted mb-4">{{ $s['text'] }}</p>

            @if (!empty($refid))
                <p class="small mb-4">রেফারেন্স আইডি: <strong class="en">{{ $refid }}</strong></p>
            @endif

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                @if ($retry)
                    <a href="{{ route('applicant.create') }}" class="btn btn-green">
                        <svg class="ic"><use href="#i-reset" /></svg>নতুন করে আবেদন করুন
                    </a>
                @else
                    <a href="{{ route('applicant.status') }}" class="btn btn-green">
                        <svg class="ic"><use href="#i-search" /></svg>আবেদনের অবস্থা দেখুন
                    </a>
                @endif
                <a href="{{ route('home') }}" class="btn btn-outline-green">
                    <svg class="ic"><use href="#i-home" /></svg>হোম পেজ
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
