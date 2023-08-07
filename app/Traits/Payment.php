<?php

namespace App\Traits;

use Exception;
use Razorpay\Api\Api;
use App\Models\School;
use App\Models\Package;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\SchoolBatch;
use Illuminate\Http\Request;
use App\Models\RazorpayOrder;
use App\Models\RazorpayTransaction;

trait Payment
{
    /**
     * enroll student in batch
     * @param RazorpayOrder $order
     * @param string $payment_id
     * @return bool
     */

    public function enroll(RazorpayOrder $order, string $payment_id): bool
    {
        try {
            Enrollment::create([
                'student_id' => $order->student_id,
                'school_batch_id' => $order->school_batch_id,
                'expiry_date' => now()->addDays($order->package->duration),
                'status' => 'paid',
            ]);

            RazorpayTransaction::create([
                'razorpay_order_id' => $order->id,
                'transaction_id' => $payment_id,
                'amount' => $order->payable_amount,
                'type' => 'regular',
            ]);
            $order->status = 'paid';
            $order->save();
            return true;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }




    /**
     * resolve pending order
     * @param Student $student
     * @param Request $request
     * @return bool
     */
    public function resolvePendingOrders(Request $request, Student $student, bool $is_renew): bool
    {
        $pending_orders = RazorpayOrder::where('student_id', $student->id)
            ->where('school_batch_id', $request->batch)
            ->where('status', 'pending')->get();


        if ($pending_orders->count() > 0) {
            $batch = SchoolBatch::where('id', $request->batch)->first(['id', 'members_count']);
            $is_paid = false;
            foreach ($pending_orders as $key => $ord) {

                $api = new Api(env('RAZORPAY_TEST_KEY'), env('RAZORPAY_TEST_SECRET'));
                $order = collect($api->order->fetch($ord->order_id)->payments()->toArray()['items'])->map(function ($data) {
                    if ($data['status'] == 'captured') {
                        return $data;
                    } else {
                    }
                })->first();
                if (empty($order)) {
                    $ord->status = 'failed';
                    $ord->save();
                    if (!$is_renew) {
                        $batch->members_count = $batch->members_count - 1;
                        $batch->save();
                    }
                } else {
                    $is_paid = true;
                    $this->enroll($ord, $order['id']);
                }
            }


            return $is_paid;
        } else {
            return false;
        }
    }

    /**
     * Generate order for package
     * @param Request $request
     */

    public function generateOrder(Request $request): array
    {
        $student = $request->user();
        $is_renew = Enrollment::where('student_id', $student->id)
            ->where('school_batch_id', $request->batch)
            ->exists();
        $pending_order = $this->resolvePendingOrders($request, $student, $is_renew);
        if ($pending_order) {
            return response(['status' => 'already paid', 'message' => 'You have already paid for this package']);
        }

        $api = new Api(env('RAZORPAY_TEST_KEY'), env('RAZORPAY_TEST_SECRET'));
        $package = Package::find($request->package);
        $batch = SchoolBatch::find($request->batch);
        $school = School::where('id', $batch->school_id)->with(['school_price:id,school_id,price'])->first(['id']);

        $amount =  (int)($package->duration / 30) * $school->school_price->price;


        $response = $api->order->create(
            [
                'receipt' => 'order_rcpt_' . uniqid(),
                'amount' => $amount * 100,
                'currency' => 'INR',
                'notes' => [
                    'package' => $package->name,
                    'batch code' => $batch->code,
                    'student name' => $student->name,
                    'student email' => $student->email,
                ]
            ]
        );

        $order = RazorpayOrder::create([
            'student_id' => $student->id,
            'package_id' => $package->id,
            'school_batch_id' => $batch->id,
            'order_id' => $response->id,
            'mrp' => $amount,
            'discount' => 0,
            'discount_amount' => 0,
            'payable_amount' => $amount,
            'type' => $package->type,
        ]);
        if (!$is_renew) {
            $batch->increment('members_count');
        }

        return ['status' => 'success', 'order_id' => $response->id, 'order' => $order];
    }


    /**
     * enroll student in batch if payment is successful
     * @param Request $request
     * @return array
     */

    public function processOrder(Request $request): array
    {
        $order = RazorpayOrder::where('order_id', $request->order_id)->latest('id')->first();

        if ($order->status == 'paid') {
            return ['status' => 'success', 'msg' => 'Already paid'];
        }
        if ($order->status == 'failed') {
            return ['status' => 'failed', 'msg' => 'Payment failed'];
        }

        $api = new Api(env('RAZORPAY_TEST_KEY'), env('RAZORPAY_TEST_SECRET'));
        $response = $api->order->fetch($request->order_id)->payments()->toArray();

        foreach ($response['items'] as $key => $item) {
            if ($item['status'] == 'captured') {
                if ($this->enroll($order, $item['id'])) {
                    return ['status' => 'success', 'msg' => 'Payment successful'];
                }
            }
        }
        $order->status = 'failed';
        $order->save();
        return ['status' => 'failed', 'msg' => 'Payment failed'];
    }
}
