<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class CreateTotalPembayaranView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        create or replace view total_pembayaran as with pay as (
        select
            distinct adjusment_amount,
            created_at,
            student_id
        from
            payment ),
        student_pay as (
        select
            s.id as id_murid,
            s.nis as nomor_induk_siswa,
            s.name as nama_murid,
            p.created_at as tanggal_bayar,
            sum(coalesce(p.amount, 0)) as total_pembayaran,
            payment_method as metode_pembayaran
        from
            student s
        left join payment p on
            s.id = p.student_id
        group by
            s.id,
            s.nis,
            s.name,
            4,
            payment_method)
        select
            id_murid,
            nomor_induk_siswa,
            nama_murid,
            (total_pembayaran - coalesce(adjusment_amount, 0)) as total_akhir,
            tanggal_bayar,
            metode_pembayaran
        from
            student_pay
        left join pay on
            student_pay.id_murid = pay.student_id
            and student_pay.tanggal_bayar = pay.created_at");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('total_pembayaran');
    }
}
