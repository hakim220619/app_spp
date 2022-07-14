<?php

namespace App\Traits;

use App\Models\Master\Pembayaran;

trait PaymentTraits
{
    public function getPayment($studentId, $categoryId, $find = null)
    {
        $pembayaran = Pembayaran::where('student_id', $studentId)
            ->where('category_payment_id', $categoryId);
        if ($find) {
            $pembayaran->where('description', 'like', $find . '%');
        }
        $pembayaran = $pembayaran->get()->toArray();

        if (count($pembayaran) == 0) {
            return '';
        }

        if (count($pembayaran) == 1) {
            return $pembayaran[0]['description'];
        }

        $desc = '';
        foreach ($pembayaran as $data) {
            $split = explode(' - ', $data['description']);
            $desc .= $split[1];
        }

        return $find . ' - ' . $desc;
    }
}
