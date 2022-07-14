<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateJumlahSppView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            create or replace view jumlah_spp as
            select
            c.name as  kelas,
            u2.name as unit,
            -- s.gender as jenis_kelamin,
            -- cp.type as jenis_pembayaran,
            sum(case when lower(p.description) like '%jan%' then 1
                 when cp.type = 'Pertahun' and extract(year from current_date) = cast(SUBSTRING(p.description ,8,12) as SIGNED) then 1
            else 0 end) january,
            sum(case when lower(p.description) like '%feb%' then 1
                 when cp.type = 'Pertahun' and extract(year from current_date) = cast(SUBSTRING(p.description ,8,12) as SIGNED) then 1
            else 0 end) febuary,
            sum(case when lower(p.description) like '%mar%' then 1
                 when cp.type = 'Pertahun' and extract(year from current_date) = cast(SUBSTRING(p.description ,8,12) as SIGNED) then 1
            else 0 end) maret,
            sum(case when lower(p.description) like '%apr%' then 1
                 when cp.type = 'Pertahun' and extract(year from current_date) = cast(SUBSTRING(p.description ,8,12) as SIGNED) then 1
            else 0 end) april,
            sum(case when lower(p.description) like '%mei%' then 1
                 when cp.type = 'Pertahun' and extract(year from current_date) = cast(SUBSTRING(p.description ,8,12) as SIGNED) then 1
            else 0 end) mei,
            sum(case when lower(p.description) like '%jun%' then 1
                 when cp.type = 'Pertahun' and extract(year from current_date) = cast(SUBSTRING(p.description ,8,12) as SIGNED) then 1
            else 0 end) juni,
            -- pertahun update
            sum(case when lower(p.description) like '%jul%' then 1
                 when cp.type = 'Pertahun' and extract(year from current_date) = cast(SUBSTRING(p.description ,1,4) as SIGNED) then 1
            else 0 end) july,
            sum(case when lower(p.description) like '%agu%' then 1
                 when cp.type = 'Pertahun' and extract(year from current_date) = cast(SUBSTRING(p.description ,1,4) as SIGNED) then 1
            else 0 end) agustus,
            sum(case when lower(p.description) like '%sep%' then 1
                 when cp.type = 'Pertahun' and extract(year from current_date) = cast(SUBSTRING(p.description ,1,4) as SIGNED) then 1
            else 0 end) september,
            sum(case when lower(p.description) like '%okt%' then 1
                 when cp.type = 'Pertahun' and extract(year from current_date) = cast(SUBSTRING(p.description ,1,4) as SIGNED) then 1
            else 0 end) oktober,
            sum(case when lower(p.description) like '%nov%' then 1
                 when cp.type = 'Pertahun' and extract(year from current_date) = cast(SUBSTRING(p.description ,1,4) as SIGNED) then 1
            else 0 end) november,
            sum(case when lower(p.description) like '%des%' then 1
                 when cp.type = 'Pertahun' and extract(year from current_date) = cast(SUBSTRING(p.description ,1,4) as SIGNED) then 1
            else 0 end) desember
            from payment p
            inner join student s on p.student_id  = s.id
            left join class c on s.class_id = c.id
            left join unit u2 on u2.id = c.unit_id
            left join category_payment cp on cp.id = p.category_payment_id
            where s.status = 'Aktif' and cp.name = 'SPP'
            and
            (extract(year from current_date) = cast(SUBSTRING_INDEX(p.description ,' - ',1) as SIGNED)
            or
            extract(year from current_date) = case when cp.type = 'Pertahun' then cast(SUBSTRING(p.description ,8,12) as SIGNED) end
            )
            group by 1,2
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jumlah_spp');
    }
}
