@extends('layouts.app')

@section('content')

            <section class="hero">
                <div class="container">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-7">
                            <span class="hero-chip"><svg class="ic">
                                    <use href="#i-badge" />
                                </svg>Rickshaw License Management System</span>
                            <h1>রিক্সা লাইসেন্সের জন্য<br>অনলাইনে আবেদন করুন</h1>
                            <p class="lead">ঢাকা ক্যান্টনমেন্ট এলাকায় রিক্সা লাইসেন্সের আবেদন, অবস্থা যাচাই এবং ফি
                                প্রদান এখন এক জায়গায়।</p>
                        </div>
                        <div class="col-lg-5 col-xl-4 ms-lg-auto">
                            <div class="deadline-card">
                                <span class="lbl"><svg class="ic">
                                        <use href="#i-calendar" />
                                    </svg>আবেদনের শেষ তারিখ</span>
                                <div class="date">
                                    {{ bn_number(date('d-m-Y', strtotime($app_setting->app_expire_date))) }}</div>
                                <div class="bar" role="img" aria-label="সময় প্রায় শেষ"><span></span></div>
                                <div class="note">সময় প্রায় শেষ, দ্রুত আবেদন করুন</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- The two main buttons -->
            <div class="container cta-wrap">
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('applicant.create') }}" class="cta cta-apply">
                            <span class="cta-icon"><svg class="ic ic-lg">
                                    <use href="#i-file" />
                                </svg></span>
                            <span>
                                <span class="cta-title">নতুন আবেদন করুন</span>
                                <span class="cta-sub">ফরম পূরণ করুন ও {{ \App\Helpers\Helper::en2bn($app_setting->application_fee) ?? 0 }}/- টাকা আবেদন ফি দিন</span>
                            </span>
                            <svg class="ic cta-arrow">
                                <use href="#i-arrow" />
                            </svg>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('applicant.status') }}" class="cta cta-status">
                            <span class="cta-icon"><svg class="ic ic-lg">
                                    <use href="#i-search" />
                                </svg></span>
                            <span>
                                <span class="cta-title">আবেদনের অবস্থা ও ফি প্রদান</span>
                                <span class="cta-sub">NID ও মোবাইল নম্বর দিয়ে অবস্থা দেখুন</span>
                            </span>
                            <svg class="ic cta-arrow">
                                <use href="#i-arrow" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <main class="container py-5">

                <!-- Steps -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="step-card">
                            <div class="step-num">১</div>
                            <h3>আবেদন করুন</h3>
                            <p>ফরম পূরণ করে ডকুমেন্ট দিন এবং {{ \App\Helpers\Helper::en2bn($app_setting->application_fee) ?? 0 }}/- টাকা আবেদন ফি অনলাইনে পরিশোধ করুন।</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-card">
                            <div class="step-num">২</div>
                            <h3>অনুমোদন</h3>
                            <p>আবেদন যাচাইয়ের পর অবস্থা অনুসন্ধান পাতায় অনুমোদনের তথ্য দেখুন।</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-card">
                            <div class="step-num">৩</div>
                            <h3>বার্ষিক ফি প্রদান</h3>
                            <p>অনুমোদিত হলে বার্ষিক লাইসেন্স ফি পরিশোধ করে রশিদ ডাউনলোড করুন।</p>
                        </div>
                    </div>
                </div>

                <!-- Fee tiles -->
                <div class="row g-3 mb-5">
                    <div class="col-6 col-lg-3">
                        <div class="tile gold">
                            <div class="k">আবেদন ফি</div>
                            <div class="v">{{ \App\Helpers\Helper::en2bn($app_setting->application_fee) ?? 0 }}/-</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="tile green">
                            <div class="k">বার্ষিক ফি</div>
                            <div class="v">{{ \App\Helpers\Helper::en2bn($app_setting->yearly_fee) ?? 0 }}/-</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="tile green">
                            <div class="k">ভ্যাট</div>
                            <div class="v">{{ \App\Helpers\Helper::en2bn(intval($app_setting->tax_percent)) ?? 0 }}%</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="tile green">
                            <div class="k">নিরাপত্তা ফি</div>
                            <div class="v"><div class="v">{{ \App\Helpers\Helper::en2bn($app_setting->security_fee) ?? 0 }}/-</div>
                        </div>
                    </div>
                </div>

                <!-- Rules -->
                <h2 class="sec-title">আবেদনের নির্দেশনা</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-user" />
                                </svg><small>১</small></span>
                            <p>একজন ব্যক্তি একের অধিক কোটায় আবেদন করতে পারবেন না। আবেদনকারী মনোনীত হলে <strong>১টি
                                    লাইসেন্স</strong> ইজারা/বরাদ্দ পাবেন।</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-cash" />
                                </svg><small>২</small></span>
                            <p>আবেদনের সাথে সিইও, ঢাকা ক্যান্টনমেন্ট এর অনুকূলে লাইসেন্স ফি বাবদ <strong>{{ \App\Helpers\Helper::en2bn($app_setting->yearly_fee) ?? 0 }}/- (সাত
                                    হাজার তিনশত)</strong> টাকার পে-অর্ডারের কপিসহ তথ্য প্রদান করতে হবে। আবেদনকারী মনোনীত
                                হলে পে-অর্ডার জমা প্রদান করতে হবে।</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-percent" />
                                </svg><small>৩</small></span>
                            <p>রিক্সার লাইসেন্সের জন্য অনুমতিপ্রাপ্ত হলে লাইসেন্স ফি এর উপর <strong>১৫% ভ্যাট ও ১০%
                                    উৎসকর</strong> প্রদান করতে হবে। এছাড়া প্রতিটি লাইসেন্সের জন্য <strong>৩০০০/- (তিন
                                    হাজার)</strong> টাকা জমা রাখতে হবে। এর মধ্যে জামানত বাবদ ২০০০/- টাকা লাইসেন্সের
                                মেয়াদ শেষে ফেরতযোগ্য। অবশিষ্ট ১০০০/- টাকা রিক্সা মনিটরিং ফি বাবদ কর্তন করা হবে।</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-alert" />
                                </svg><small>৪</small></span>
                            <p>রিক্সার লাইসেন্স বিক্রয় করা যাবে না, তবে ভাড়া প্রদান করতে পারবেন। কোনো অনিয়ম পরিলক্ষিত
                                হলে <strong>জামানত বাজেয়াপ্ত</strong> ও প্রয়োজনীয় আইনানুগ ব্যবস্থা গ্রহণ করা হবে।</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-pin" />
                                </svg><small>৫</small></span>
                            <p>আবেদনকারী ঢাকা সিটিকর্পোরেশন বা ঢাকা ক্যান্টনমেন্ট বোর্ডের আওতাধীন এলাকায় বসবাসকারী হতে
                                হবে। প্রমানক হিসেবে সংশ্লিষ্ট এলাকার <strong>নাগরিক সনদপত্র</strong> দাখিল করতে হবে।</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-paperclip" />
                                </svg><small>৬</small></span>
                            <p>সকল কোটার আবেদনের ক্ষেত্রে <strong>কোটার প্রমানক</strong> সংযুক্ত করতে হবে।</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-printer" />
                                </svg><small>৭</small></span>
                            <p>অনলাইনে আবেদন করার পর আবেদনের প্রিন্ট কপিসহ ঢাকা ক্যান্টনমেন্ট বোর্ডের রাজস্ব শাখায়
                                <strong>২০০/-টাকা</strong> আবেদন ফি জমা করার জন্য অনুরোধ করা হলো অন্যথায় আপনার আবেদনটি
                                বাতিল বলে গণ্য হবে।</p>
                        </div>
                    </div>
                </div>
            </main>
@endsection
