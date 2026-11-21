<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSetting;
use App\Models\Area;
use App\Helpers\Helper;
use BaconQrCode\Writer;
use App\Models\Category;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use BaconQrCode\Renderer\ImageRenderer;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use App\Services\JanataPayService;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends Controller
{
    public function home()   
    { 
        return view('applicant.home',   ['app_setting' => ApplicationSetting::first()]); 
    }
    
    public function create()
    {
        $areas = Area::select('id', 'area_name')->get();
        $categories = Category::where('category_slug','N/A')->select('id', 'category_name')->get();
        $app_setting = ApplicationSetting::latest()->first();
        return view('applicant.apply', compact('areas', 'categories','app_setting'));
    }
    public function status() 
    { 
        $areas = Area::select('id', 'area_name')->get();
        $categories = Category::where('category_slug','N/A')->select('id', 'category_name')->get();
        $app_setting = ApplicationSetting::latest()->first();
        return view('applicant.status', ['areas' => $areas, 'categories' => $categories /* + $editCategories */]); 
    }
    public function store(Request $request)
    {
        $request->merge([
            'nid_no' => Helper::bn2en($request->nid_no),
            'phone'  => Helper::bn2en($request->phone),
        ]);
        $validated = $request->validate([
            'area_id'           => 'required|exists:areas,id',
            'category_id'       => 'required|exists:categories,id',

            'applicant_name'    => 'required|string|max:255|regex:/^(?!.*[A-Za-z]).*$/u',
            'guardian_name'     => 'required|string|max:255|regex:/^(?!.*[A-Za-z]).*$/u',
            'present_address'   => 'required|string|max:255|regex:/^(?!.*[A-Za-z]).*$/u',
            'permanent_address' => 'required|string|max:255|regex:/^(?!.*[A-Za-z]).*$/u',
            'nid_no' => [
                            'required',
                            'string',
                            'max:50',
                            Rule::unique('applicants')->where(function ($query) use ($request) {
                                return $query->where('applicant_year', date('Y'));
                            }),
                        ],
            'email'             => 'nullable|email|max:255',
            'phone' => [
                            'required',
                            'digits_between:10,11',
                            Rule::unique('applicants')->where(function ($query) use ($request) {
                                return $query->where('applicant_year', date('Y'));
                            }),
                        ],

            // File validation
            'applicant_image'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'citizen_certificate_image'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'category_proof_image'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'nid_image'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ],[
            // Custom messages
            // Area & Category
            'area_id.required'  => 'এরিয়া নির্বাচন করুন।',
            'area_id.exists'    => 'নির্বাচিত এরিয়া সঠিক নয়।',

            'category_id.required' => 'ক্যাটাগরি নির্বাচন করুন।',
            'category_id.exists'   => 'নির্বাচিত ক্যাটাগরি সঠিক নয়।',

            // Applicant Information
            'applicant_name.required' => 'আবেদনকারীর নাম প্রদান করুন।',
            'applicant_name.string'   => 'আবেদনকারীর নাম অবশ্যই টেক্সট হতে হবে।',
            'applicant_name.max'      => 'আবেদনকারীর নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',
            'applicant_name.regex' => 'শুধুমাত্র বাংলা অক্ষর ও বাংলা সংখ্যা (০-৯) লিখতে পারবেন।',

            'guardian_name.required' => 'পিতা/স্বামীর নাম প্রদান করুন।',
            'guardian_name.string'   => 'পিতা/স্বামীর নাম অবশ্যই টেক্সট হতে হবে।',
            'guardian_name.max'      => 'পিতা/স্বামীর নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',
            'guardian_name.regex' => 'শুধুমাত্র বাংলা অক্ষর ও বাংলা সংখ্যা (০-৯) লিখতে পারবেন।',

            'present_address.required' => 'বর্তমান ঠিকানা প্রদান করুন।',
            'present_address.string'   => 'বর্তমান ঠিকানা অবশ্যই টেক্সট হতে হবে।',
            'present_address.max'      => 'বর্তমান ঠিকানা সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',
            'present_address.regex' => 'শুধুমাত্র বাংলা অক্ষর ও বাংলা সংখ্যা (০-৯) লিখতে পারবেন।',

            'permanent_address.required' => 'স্থায়ী ঠিকানা প্রদান করুন।',
            'permanent_address.string'   => 'স্থায়ী ঠিকানা অবশ্যই টেক্সট হতে হবে।',
            'permanent_address.max'      => 'স্থায়ী ঠিকানা সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',
            'permanent_address.regex' => 'শুধুমাত্র বাংলা অক্ষর ও বাংলা সংখ্যা (০-৯) লিখতে পারবেন।',

            // Email
            'email.email' => 'সঠিক ইমেইল এড্রেস প্রদান করুন।',
            'email.max'   => 'ইমেইল সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'nid_no.required' => 'NID নম্বর দিন।',
            'nid_no.unique'   => 'এই NID দিয়ে ইতোমধ্যেই আবেদন করা হয়েছে।',

            'phone.required'  => 'মোবাইল নম্বর দিন।',
            'phone.unique'    => 'এই মোবাইল নম্বর দিয়ে ইতোমধ্যে আবেদন করা হয়েছে।',
            'phone.digits_between' => 'মোবাইল নম্বর অবশ্যই ১০ থেকে ১১ ডিজিটের হতে হবে।',

            'applicant_image.required' => 'আবেদনকারীর ছবি আপলোড করুন।',
            'applicant_image.mimes'    => 'আবেদনকারীর ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',

            'citizen_certificate_image.required' => 'নাগরিক সনদের ছবি আপলোড করুন।',
            'citizen_certificate_image.mimes'    => 'নাগরিক সনদের ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',

            'category_proof_image.required' => 'ক্যাটাগরি প্রমানক ছবি আপলোড করুন।',
            'category_proof_image.mimes'    => 'ক্যাটাগরি প্রমানক ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',

            'nid_image.required' => 'NID এর ছবি আপলোড করুন।',
            'nid_image.mimes'    => 'NID ছবি অবশ্যই JPG, JPEG, PNG বা PDF হতে হবে।',
        ]);

        // Convert date fields
        if (!empty($validated['order_date'])) {
            $validated['order_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validated['order_date'])->format('Y-m-d');
        }

        
        if ($request->hasFile('applicant_image')) {
            // $validated['applicant_image'] = $request->file('applicant_image')->store('applicant', 'public');
            $validated['applicant_image'] = Helper::compress($request->file('applicant_image'), 'applicant', 50);
        }

        if ($request->hasFile('signature_image')) {
            // $validated['signature_image'] = $request->file('signature_image')->store('signature', 'public');
            $validated['signature_image'] = Helper::compress($request->file('signature_image'), 'signature', 50);

        }

        if ($request->hasFile('nid_image')) {
            // $validated['nid_image'] = $request->file('nid_image')->store('nid', 'public');
            $validated['nid_image'] = Helper::compress($request->file('nid_image'), 'nid', 50);
        }

        if ($request->hasFile('py_order_image')) {
            // $validated['py_order_image'] = $request->file('py_order_image')->store('pay_order', 'public');
            $validated['py_order_image'] = Helper::compress($request->file('py_order_image'), 'pay_order', 50);
        }

        if ($request->hasFile('citizen_certificate_image')) {
            // $validated['citizen_certificate_image'] = $request->file('citizen_certificate_image')->store('citizen_certificate', 'public');
            $validated['citizen_certificate_image'] = Helper::compress($request->file('citizen_certificate_image'), 'citizen_certificate', 50);
        }

        if ($request->hasFile('category_proof_image')) {
            // $validated['category_proof_image'] = $request->file('category_proof_image')->store('category_proof', 'public');
            $validated['category_proof_image'] = Helper::compress($request->file('category_proof_image'), 'category_proof', 50);
        }

        $applicant = Applicant::create($validated);

        // Get the application fee from server-side configuration.
        $applicationFee = 200;

        try {
            // Initiate JanataPay payment.
            $paymentUrl = app(JanataPayService::class)->startPayment(
                applicantId: $applicant->id,
                paymentType: 'application_fee',
                amount: $applicationFee,
                createdBy: null
            );

            // Redirect applicant to JanataPay.
            return redirect()->away($paymentUrl);

        } catch (Throwable $e) {

            // The applicant has already been saved.
            // Do not create the applicant again if payment initiation fails.
            Log::error('JanataPay payment initiation failed', [
                'applicant_id' => $applicant->id,
                'error' => $e->getMessage(),
            ]);
            // Remove the application and its uploaded files
            $this->discardApplicant($applicant);

            return redirect()->back()
                ->withInput($request->except([
                    'applicant_image', 'citizen_certificate_image', 'category_proof_image', 'nid_image',
                ]))
                ->with('error', 'পেমেন্ট শুরু করা যায়নি, তাই আপনার আবেদনটি সংরক্ষণ করা হয়নি। অনুগ্রহ করে আবার আবেদন করুন।');
        }
    }
    private function discardApplicant(Applicant $applicant): void
    {
        $fileFields = ['applicant_image', 'signature_image', 'nid_image', 'citizen_certificate_image', 'category_proof_image'];

        try {
            DB::transaction(function () use ($applicant, $fileFields) {
                // collect file paths before deleting the row
                $paths = collect($fileFields)->map(fn ($f) => $applicant->{$f})->filter()->all();

                // payment rows that startPayment() may have created before it failed
                if ($applicant->paymentInfo) {
                    $applicant->paymentInfo->applicationFee?->delete();
                    $applicant->paymentInfo->delete();
                }

                $applicant->delete();   // use forceDelete() if Applicant uses SoftDeletes

                // delete files only after the DB delete has succeeded
                DB::afterCommit(function () use ($paths) {
                    foreach ($paths as $path) {
                        Storage::disk('public')->delete($path);
                    }
                });
            });
        } catch (Throwable $e) {
            Log::error('Failed to discard applicant after payment failure', [
                'applicant_id' => $applicant->id,
                'error'        => $e->getMessage(),
            ]);
        }
    }
    public function search(Request $request)
    {
        // Accept English or Bangla digits, ignore spaces/dashes
        $term = preg_replace('/\D+/', '', Helper::bn2en((string) $request->search));

        if ($term === '') {
            return response()->json(['error' => 'NID অথবা মোবাইল নম্বর দিতে হবে']);
        }

        // phone may be stored as 01712345678 or 1712345678 (rule: digits_between:10,11)
        $phones = [$term];
        if (strlen($term) === 10) $phones[] = '0' . $term;
        if (strlen($term) === 11 && str_starts_with($term, '0')) $phones[] = substr($term, 1);

        $settings = ApplicationSetting::latest()->first();

        $applicant = Applicant::with([
                        'paymentInfo',
                        'paymentInfo.applicationFee',
                        'paymentInfo.yearlyFee',
                        'paymentInfo.securityFee',
                        'paymentInfo.refunds',
                        'area',
                        'category',
                    ])
                    ->where('applicant_year', date('Y'))
                    ->where(function ($q) use ($term, $phones) {
                        $q->where('nid_no', $term)->orWhereIn('phone', $phones);
                    })
                    ->latest()
                    ->first();
        if (!$applicant) {
            return response()->json(['error' => 'কোনো তথ্য পাওয়া যায়নি']);
        }
        // --- Payment status flags ---
        $paymentInfo = $applicant->paymentInfo;

        $applicationFeePaid = $paymentInfo?->applicationFee?->status === 'paid';
        $yearlyFeePaid      = $paymentInfo?->yearlyFee?->status === 'paid';
        $securityFeePaid    = $paymentInfo?->securityFee?->status === 'paid';
        $yearlyFeePartial   = $paymentInfo?->yearlyFee?->status === 'partial';

        $html = view('applicant.search', compact('applicant',
        'settings',
        'paymentInfo',
        'applicationFeePaid',
        'yearlyFeePaid',
        'securityFeePaid',
        'yearlyFeePartial'))->render();
        return response()->json(['html' => $html]);
    }
    

    public function print(Request $request)
    {
        $id = $request->id;

        if (!$id ) {
            abort(404, "Invalid request.");
        }

        $applicant = Applicant::findOrFail($id);;

        if (!$applicant) {
            abort(404, "Application not found.");
        }

        $printUrl = url('/application/print') . '?id=' . $applicant->id;

        // SVG-based QR code (no Imagick required)
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qr = $writer->writeString($printUrl);


        $qrImage = 'data:image/svg+xml;base64,' . base64_encode($qr);

        return view('applicant.print', compact('applicant','qrImage'));
    }
    
    public function viewDetails($id)
    {
        $applicant = Applicant::query()->where('id',$id)->first();
        // if($applicant->status!='pending' && $applicant->status!='rejected'){
        //     return redirect()->route('home');
        // }
        $areas = Area::select('id', 'area_name')->get();
        $categories = Category::select('id', 'category_name')->get();
        $app_setting = ApplicationSetting::select('application_fee')->latest()->first();
        return view('applicant.applicantdetails', compact('applicant','areas', 'categories','app_setting'));
    }

    public function edit($id)
    {
        $applicant = Applicant::findOrFail($id);
        if($applicant->status!='pending' && $applicant->status!='rejected'){
            return redirect()->route('home');
        }
        $areas = Area::select('id', 'area_name')->get();
        $categories = Category::select('id', 'category_name')->get();
        $app_setting = ApplicationSetting::select('application_fee')->latest()->first();
        return view('applicant.edit', compact('applicant','areas', 'categories','app_setting'));
    }

    public function update(Request $request, Applicant $applicant)
    {
        // Convert Bangla numbers before validation
        $request->merge([
            'amount' => Helper::bn2en($request->amount),
            'nid_no' => Helper::bn2en($request->nid_no),
            'phone'  => Helper::bn2en($request->phone),
        ]);

        $validated = $request->validate([
            'area_id'           => 'required|exists:areas,id',
            'category_id'       => 'required|exists:categories,id',

            
            'applicant_name'    => 'required|string|max:255|regex:/^(?!.*[A-Za-z]).*$/u',
            'guardian_name'     => 'required|string|max:255|regex:/^(?!.*[A-Za-z]).*$/u',
            'present_address'   => 'required|string|max:255|regex:/^(?!.*[A-Za-z]).*$/u',
            'permanent_address' => 'required|string|max:255|regex:/^(?!.*[A-Za-z]).*$/u',

            'nid_no' => [
                'required',
                'string',
                'max:50',
                Rule::unique('applicants', 'nid_no')
                    ->ignore($applicant->id, 'id')
                    ->where(fn ($query) => $query->where('applicant_year', $applicant->applicant_year)),
            ],

            'email' => 'nullable|email|max:255',
            'phone' => [
                'required',
                'digits_between:10,11',
                Rule::unique('applicants',  'phone')
                    ->ignore($applicant->id, 'id')
                    ->where(fn ($query) => $query->where('applicant_year', $applicant->applicant_year)),
            ],

            // Images → optional during update
            'applicant_image'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'citizen_certificate_image'=> 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'category_proof_image'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'nid_image'                => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ],[
            // Custom messages
            // Area & Category
            'area_id.required'  => 'এরিয়া নির্বাচন করুন।',
            'area_id.exists'    => 'নির্বাচিত এরিয়া সঠিক নয়।',

            'category_id.required' => 'ক্যাটাগরি নির্বাচন করুন।',
            'category_id.exists'   => 'নির্বাচিত ক্যাটাগরি সঠিক নয়।',

            // Applicant Information
            'applicant_name.required' => 'আবেদনকারীর নাম প্রদান করুন।',
            'applicant_name.string'   => 'আবেদনকারীর নাম অবশ্যই টেক্সট হতে হবে।',
            'applicant_name.max'      => 'আবেদনকারীর নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',
            'applicant_name.regex' => 'শুধুমাত্র বাংলা অক্ষর ও বাংলা সংখ্যা (০-৯) লিখতে পারবেন।',

            'guardian_name.required' => 'পিতা/স্বামীর নাম প্রদান করুন।',
            'guardian_name.string'   => 'পিতা/স্বামীর নাম অবশ্যই টেক্সট হতে হবে।',
            'guardian_name.max'      => 'পিতা/স্বামীর নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',
            'guardian_name.regex' => 'শুধুমাত্র বাংলা অক্ষর ও বাংলা সংখ্যা (০-৯) লিখতে পারবেন।',

            'present_address.required' => 'বর্তমান ঠিকানা প্রদান করুন।',
            'present_address.string'   => 'বর্তমান ঠিকানা অবশ্যই টেক্সট হতে হবে।',
            'present_address.max'      => 'বর্তমান ঠিকানা সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',
            'present_address.regex' => 'শুধুমাত্র বাংলা অক্ষর ও বাংলা সংখ্যা (০-৯) লিখতে পারবেন।',

            'permanent_address.required' => 'স্থায়ী ঠিকানা প্রদান করুন।',
            'permanent_address.string'   => 'স্থায়ী ঠিকানা অবশ্যই টেক্সট হতে হবে।',
            'permanent_address.max'      => 'স্থায়ী ঠিকানা সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',
            'permanent_address.regex' => 'শুধুমাত্র বাংলা অক্ষর ও বাংলা সংখ্যা (০-৯) লিখতে পারবেন।',

            // Email
            'email.email' => 'সঠিক ইমেইল এড্রেস প্রদান করুন।',
            'email.max'   => 'ইমেইল সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'nid_no.required' => 'NID নম্বর দিন।',
            'nid_no.unique'   => 'এই NID দিয়ে ইতোমধ্যেই আবেদন করা হয়েছে।',

            'phone.required'  => 'মোবাইল নম্বর দিন।',
            'phone.unique'    => 'এই মোবাইল নম্বর দিয়ে ইতোমধ্যে আবেদন করা হয়েছে।',
            'phone.digits_between' => 'মোবাইল নম্বর অবশ্যই ১০ থেকে ১১ ডিজিটের হতে হবে।',

            'applicant_image.required' => 'আবেদনকারীর ছবি আপলোড করুন।',
            'applicant_image.mimes'    => 'আবেদনকারীর ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',

            'citizen_certificate_image.required' => 'নাগরিক সনদের ছবি আপলোড করুন।',
            'citizen_certificate_image.mimes'    => 'নাগরিক সনদের ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',

            'category_proof_image.required' => 'ক্যাটাগরি প্রমানক ছবি আপলোড করুন।',
            'category_proof_image.mimes'    => 'ক্যাটাগরি প্রমানক ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',

            'nid_image.required' => 'NID এর ছবি আপলোড করুন।',
            'nid_image.mimes'    => 'NID ছবি অবশ্যই JPG, JPEG, PNG বা PDF হতে হবে।',
        ]);

        // Convert date format if needed
        if (!empty($validated['order_date'])) {
            $validated['order_date'] = \Carbon\Carbon::parse($validated['order_date'])->format('Y-m-d');
        }

        // Handle file uploads (replace only if new file uploaded)
        foreach ([
            'applicant_image' => 'applicant',
            'signature_image' => 'signature',
            'nid_image'       => 'nid',
            'citizen_certificate_image' => 'citizen_certificate',
            'category_proof_image' => 'category_proof',
        ] as $field => $folder) {

            if ($request->hasFile($field)) {

                // delete old file if exists
                if ($applicant->$field && \Storage::disk('public')->exists($applicant->$field)) {
                    \Storage::disk('public')->delete($applicant->$field);
                }

                // $validated[$field] = $request->file($field)->store($folder, 'public');
                $validated[$field] = Helper::compress($request->file($field), $folder, 50);
            }
        }
        
        $applicant->update($validated);
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'আপনার আবেদন সফলভাবে সম্পাদন হয়েছে!',
                'nid_no'  => $applicant->nid_no,        // used to refresh the search result
            ]);
        }
    }
    public function payYearlyFee(Request $request,Applicant $applicant)
    {
        // NEW: only approved applications can pay (adjust to your rule)
        if ($applicant->status !== 'approved') {
            return $this->fail($request, 'আপনার আবেদনটি এখনো অনুমোদিত হয়নি।');
        }

        // NEW: block a second payment
        if ($applicant->paymentInfo?->yearlyFee?->status === 'paid') {
            return $this->fail($request, 'বার্ষিক ফি ইতোমধ্যে পরিশোধ করা হয়েছে।');
        }
        // Load the latest application settings.
        $settings = ApplicationSetting::latest()->first();

        if (!$settings) {
            return $this->fail($request, 'পেমেন্ট সেটিংস পাওয়া যায়নি।');
        }

        // Calculate payment amount on the server.
        $yearlyFee = (float) ($settings->yearly_fee ?? 0);
        $securityFee = (float) ($settings->security_fee ?? 0);
        $taxPercent = (float) ($settings->tax_percent ?? 0);

        $subtotal = $yearlyFee + $securityFee;
        $vatAmount = ($subtotal * $taxPercent) / 100;
        $totalAmount = round($subtotal + $vatAmount, 2);

        if ($totalAmount <= 0) {
            return $this->fail($request, 'পেমেন্টের পরিমাণ সঠিক নয়।');
        }

        try {
            $paymentUrl = app(JanataPayService::class)->startPayment(
                applicantId: $applicant->id,
                paymentType: 'yearly_fee',
                amount: (int) round($totalAmount),
                createdBy: null
            );

            return $request->expectsJson()
            ? response()->json(['redirect' => $paymentUrl])    // JavaScript sends the browser to JanataPay
            : redirect()->away($paymentUrl); 

        } catch (Throwable $e) {

            Log::error('JanataPay yearly fee payment initiation failed', [
                'applicant_id' => $applicant->id,
                'amount' => $totalAmount,
                'error' => $e->getMessage(),
            ]);

           return $this->fail($request, 'পেমেন্ট শুরু করা যায়নি। অনুগ্রহ করে আবার চেষ্টা করুন।', 500);
        }
    }
    private function fail(Request $request, string $message, int $status = 422)
    {
        return $request->expectsJson()
            ? response()->json(['message' => $message], $status)
            : back()->with('error', $message);
    }

}
