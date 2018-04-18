<div style="padding:10px">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="mySearch">
        <li role="presentation" class="active"><a href=".home-tab" aria-controls="home" role="tab" data-toggle="tab">Nhà Đất <br/> Bán</a></li>
        <li role="presentation"><a href=".profile-tab" aria-controls="profile" role="tab" data-toggle="tab">Nhà Đất<br/> Cho Thuê</a></li>
        <!-- <li role="presentation"><a href=".messages-tab" aria-controls="messages" role="tab" data-toggle="tab">Tìm <br/> Môi Giới</a></li> -->
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active home-tab">
            <form class="form-horizontal" method="GET" action="{{route('portal.search')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="group-form-wrapper">
                    <div class="form-group">
                        <input class="form-control" type="text" name="search_key" value="" />
                    </div>
                    @if(!empty($typeProducts))
                    <div class="form-group">
                        {{Form::select('category_id', $typeProducts, null, [
                            'class' => 'form-control',
                            'placeholder' => '-- Chọn loại nhà đất --'
                            ])
                        }}
                    </div>
                    @endif

                    <!-- <div class="form-group">
                        {{Form::select('province_id', $province, null, [
                            'class' => 'form-control',
                            'placeholder' => '-- Chọn Tỉnh --'
                            ])
                        }}
                    </div> -->

                    <div class="form-group">
                        {{Form::select('district_id', $district, null, [
                            'class' => 'form-control',
                            'placeholder' => '-- Chọn Thành phố --'
                            ])
                        }}
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="dientich" name="dientich">
                            <option value=""> -- Chọn diện tích -- </option>
                            {!!html_entity_decode($acreages)!!}
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="price" name="price">
                            <option value=""> -- Chọn mức giá -- </option>
                            {!!html_entity_decode($prices)!!}
                        </select>
                    </div>

                    <div class="form-group show-on-advance">
                        <select class="form-control" id="so_phong" name="so_phong">
                            <option value=""> -- Chọn số phòng ngù -- </option>
                            {!!html_entity_decode($rooms)!!}
                        </select>
                    </div>

                    <div class="form-group show-on-advance">
                        {{Form::select('huongnha_id', $direction, null, [
                            'class' => 'form-control',
                            'placeholder' => '-- Chọn hướng nhà --'
                            ])
                        }}
                    </div>
                </div>
                <div class="form-group text-right">
                    <button type="button" class="btn btn-success btn-show-advance">Tìm nâng cao</button>
                    <button type="button" class="btn btn-default btn-hide-advance">Tìm cơ bản</button>
                    <button type="submit" class="btn btn-warning">TÌM KIẾM</button>
                </div>
                <div class="text-right">Có <span class="total-in-day">{{$totalInDay}}</span> tin mới trong ngày</div>
            </form>
        </div>
        <div role="tabpanel" class="tab-pane profile-tab">
            <form class="form-horizontal" method="GET" action="{{route('portal.search')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="group-form-wrapper">
                    <div class="form-group">
                        <input class="form-control" type="text" name="search_key" value="" />
                    </div>
                    @if(!empty($typeProducts2))
                    <div class="form-group">
                        {{Form::select('category_id', $typeProducts2, null, [
                            'class' => 'form-control',
                            'placeholder' => '-- Chọn loại nhà đất --'
                            ])
                        }}
                    </div>
                    @endif

                    <!-- <div class="form-group">
                        {{Form::select('province_id', $province, null, [
                            'class' => 'form-control',
                            'placeholder' => '-- Chọn Tỉnh --'
                            ])
                        }}
                    </div> -->

                    <div class="form-group">
                        {{Form::select('district_id', $district, null, [
                            'class' => 'form-control',
                            'placeholder' => '-- Chọn Thành phố --'
                            ])
                        }}
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="dientich" name="dientich">
                            <option value=""> -- Chọn diện tích -- </option>
                            {!!html_entity_decode($acreages)!!}
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="price" name="price">
                            <option value=""> -- Chọn mức giá -- </option>
                            {!!html_entity_decode($prices)!!}
                        </select>
                    </div>

                    <div class="form-group show-on-advance">
                        <select class="form-control" id="so_phong" name="so_phong">
                            <option value=""> -- Chọn số phòng ngù -- </option>
                            {!!html_entity_decode($rooms)!!}
                        </select>
                    </div>

                    <div class="form-group show-on-advance">
                        {{Form::select('huongnha_id', $direction, null, [
                            'class' => 'form-control',
                            'placeholder' => '-- Chọn hướng nhà --'
                            ])
                        }}
                    </div>
                </div>
                <div class="form-group text-right">
                    <button type="button" class="btn btn-success btn-show-advance">Tìm nâng cao</button>
                    <button type="button" class="btn btn-default btn-hide-advance">Tìm cơ bản</button>
                    <button type="submit" class="btn btn-warning">TÌM KIẾM</button>
                </div>
                <div class="text-right">Có <span style="font-weight: bold;color:blue">{{$totalInDay}}</span> tin mới trong ngày</div>
            </form>
        </div>
        <div role="tabpanel" class="tab-pane messages-tab">
            <form class="form-horizontal" method="GET" action="{{route('portal.search')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="group-form-wrapper">
                    <div class="form-group">
                        <select class="form-control transaction_id" id="transaction_id" name="transaction_id">
                            <option value=""> -- Chọn loại giao dịch -- </option>
                            {{$typeTransaction}}
                        </select>
                    </div>                                            
                    <div class="form-group">
                        <select class="form-control category_id" id="category_id" name="category_id">
                            <option value=""> -- Chọn loại nhà đất -- </option>
                        </select>
                    </div>

                    <div class="form-group">
                        {{Form::select('province_id', $province, null, [
                            'class' => 'form-control',
                            'placeholder' => 'Province ID'
                            ])
                        }}
                    </div>

                    <div class="form-group">
                        {{Form::select('district_id', $district, null, [
                            'class' => 'form-control',
                            'placeholder' => 'District ID'
                            ])
                        }}
                    </div>
                </div>
                <div class="form-group text-right">
                    <button type="button" class="btn btn-default btn-hide-advance">Tìm cơ bản</button>
                    <button type="submit" class="btn btn-warning">TÌM KIẾM</button>
                </div>
            </form>
        </div>
    </div>
</div>