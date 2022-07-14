@if($errors->any())
    {{dd($errors->all())}}
@endif
<div wire:ignore.self class="modal fade" id="modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputName">Nama</label>
                                <input type="text" class="form-control" id="inputName" name="name"
                                       placeholder="Cari nama siswa / NIS"
                                       autocomplete="off" wire:model="addPayment.student.name">
                                @error('addPayment.student.name') <span
                                    class="text-danger error">{{ $message }}</span>@enderror
                                <div class="list-group position-absolute d-block w-100 pl-2 pr-2"
                                     style="left: 0; z-index: 10">
                                    @foreach($dataSearchStudent as $student)
                                        <a class="list-group-item list-group-item-action"
                                           wire:click="handleClickSearch({{$student}})">{{$student->nis}}
                                            - {{$student->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="selectMethodAdd">Metode:</label>
                                <select class="form-control" id="selectMethodAdd"
                                        wire:model="addPayment.payment_method">
                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                    @foreach($dataMethodPayment as $method)
                                        <option value="{{$method}}">{{$method}}</option>
                                    @endforeach
                                </select>
                                @error('addPayment.payment_method') <span
                                    class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        @if($unitName && $className)
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Unit:</label>
                                    <span class="form-control">{{$unitName}}</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Kelas:</label>
                                    <span class="form-control">{{$className}}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        @if($flagStudent)
                            <table class="table">
                                <thead>
                                <th style="width: 20%">Kategori</th>
                                <th style="width: 55%">Bulan / Tahun</th>
                                <th style="width: 15%">Total</th>
                                <th style="width: 10%">Action</th>
                                </thead>
                                <tbody>
                                @foreach($addPayment['categoryPayments'] as $index => $category)
                                    <tr>
                                        <td>
                                            <select name="selectNameCategory[{{$index}}]['category_payment_id']"
                                                    class="form-control"
                                                    wire:model="addPayment.categoryPayments.{{$index}}.category_payment_id">
                                                {{--                                                    wire:change="handleChangeCategory($event.target.value, {{$index}})">--}}
                                                <option value="">Pilih kategori</option>
                                                @foreach($dataCategoryPayment as $pembayaran)
                                                    <option value="{{$pembayaran['id']}}">{{$pembayaran["name"]}}
                                                        - {{$pembayaran['type']}}</option>
                                                @endforeach
                                            </select>
                                            @error('addPayment.categoryPayments.'.$index.'.category_payment_id') <span
                                                class="text-danger error">{{ $message }}</span>@enderror
                                        </td>
                                        <td>
                                            @if(isset($category['type']) && strtolower($category['type']) === 'perbulan')
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <select name="selectNameYearMonth[{{$index}}]"
                                                                    id="selectYearMonth[{{$index}}]"
                                                                    class="form-control"
                                                                    wire:model="addPayment.categoryPayments.{{$index}}.year">
                                                                <option value="">Pilih Tahun</option>
                                                                @for($i = date('Y'); $i < (date('Y') + 5); $i++)
                                                                    <option value="{{$i}}">{{$i}}</option>
                                                                @endfor
                                                            </select>
                                                            @error('addPayment.categoryPayments.'.$index.'.year') <span
                                                                class="text-danger error">{{ $message }}</span>@enderror
                                                        </div>
                                                        <div class="col-md-8">
                                                            @foreach($months as $key => $month)
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           id="inputAdd{{$month}}"
                                                                           value="{{$month}}"
                                                                           {{\Illuminate\Support\Str::containsAll($category['selectedBefore'], [$category['year'], $month]) ? 'disabled' : ""}}
                                                                           wire:model="addPayment.categoryPayments.{{$index}}.months"
                                                                           name="inputMonths[{{$index}}]">
                                                                    <label class="form-check-label"
                                                                           for="inputAdd{{$month}}">{{$month}}</label>
                                                                </div>
                                                            @endforeach
                                                            @error('addPayment.categoryPayments.'.$index.'.months')
                                                            <span
                                                                class="text-danger error">{{ $message }}</span>@enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif(isset($category['type']) && strtolower($category['type']) === 'pertahun')
                                                <select name="selectNameYear[{{$index}}]"
                                                        id="selectYear[{{$index}}]"
                                                        class="form-control"
                                                        wire:model="addPayment.categoryPayments.{{$index}}.year">
                                                    <option value="">Pilih Tahun</option>
                                                    @for($i = date('Y'); $i < (date('Y') + 5); $i++)
                                                        <option
                                                            value="{{$i}} - {{$i + 1}}"
                                                            {{\Illuminate\Support\Str::containsAll($category['selectedBefore'], [$i, $i + 1]) ? 'disabled' : ''}}
                                                        >
                                                            {{$i}} - {{$i + 1}}
                                                        </option>
                                                    @endfor
                                                </select>
                                                @error('addPayment.categoryPayments.'.$index.'.year') <span
                                                    class="text-danger error">{{ $message }}</span>@enderror
                                            @elseif(isset($category['type']) && strtolower($category['type']) === 'perjenjang')
                                                Perjenjang
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            @if(isset($category['type']) && $category['type'] != '')
                                                <label>Rp {{\App\Helper\NumberHelper::numberFormat($category['total_amount'])}}</label>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($category['type']) && $category['type'] != '')
                                                <button wire:click="handleDeleteCategory({{$index}})" type="button"
                                                        class="btn btn-danger">
                                                    <i class="fas fa-fw fa-minus"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                                <tfoot>
                                <tr>
                                    <td rowspan="2">
                                        <button wire:click="handleAddCategory" type="button" class="btn btn-primary">
                                            Tambah
                                            Kategori
                                        </button>
                                    </td>
                                    <td class="text-right"><label>Sub Total: </label></td>
                                    <td class="text-right">
                                        <label>
                                            @if($addPayment['grand_total'])
                                                Rp {{\App\Helper\NumberHelper::numberFormat($addPayment['grand_total'])}}
                                            @endif
                                        </label>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><label>Total Pengurangan: </label></td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control text-right"
                                                   placeholder="Rp 1.000.000"
                                                   wire:model.debounce.300ms="addPayment.adjustment_amount"/>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right">
                                        <label>Total:</label>
                                    </td>
                                    <td class="text-right">
                                        <label>
                                            @if($addPayment['total'])
                                                Rp {{\App\Helper\NumberHelper::numberFormat($addPayment['total'])}}
                                            @endif
                                        </label>
                                    </td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="handleCloseModal">{{config('constants.buttonTitle.close')}}</button>
                @if(!$flagEdit)
                    <button id="search" type="button" class="btn btn-primary" wire:click="save"><i
                            class="fas fa-fw fa-plus"></i>
                        {{config('constants.buttonTitle.save')}}
                    </button>
                @else
                    <button id="search" type="button" class="btn btn-primary" wire:click="handleEdit"><i
                            class="fas fa-fw fa-plus"></i>
                        {{config('constants.buttonTitle.edit')}}
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
