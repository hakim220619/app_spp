<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class CreateDetailPembayaranView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        create or replace view detail_pembayaran as
        with details as (
        select
            s.id as id_murid,
            p.id as id_pembayaran,
            s.nis as nomor_induk_siswa,
            s.name as nama_murid,
            c.name as kelas,
            concat(u.name, '-', u.grade) as nama_unit,
            s.gender as jenis_kelamin,
            cp.name as kategory_payment,
            cp.`type` as tipe_pembayaran,
            p.amount as nominal_bayar,
            coalesce(p.adjusment_amount, 0) as potongan,
            p.description as deskripsi,
            p.payment_method as metode_pembayaran,
            p.created_at as tanggal_bayar,
            case
                when p.id is null then 'Belum Bayar'
                else 'Lunas'
            end as status_bayar
        from
            student s
        join payment p on
            s.id = p.student_id
        join category_payment cp on
            p.category_payment_id = cp.id
        join class c on
            c.id = s.class_id
        join unit u on
            s.unit_id = u.id)
        select
            *
        from
            details");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pembayaran');
    }
}
