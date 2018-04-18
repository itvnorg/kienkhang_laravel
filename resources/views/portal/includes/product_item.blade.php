<div class="it-post clearfix">
    <a href="{{ route('portal.products.show', [$item->category->url_rewrite, $item->url_rewrite]) }}" title="{{$item->url_rewrite}}">
        <div class="row">
            <div class="col-sm-4 col-md-3">
                @if(! is_null($item->photo))
                    <img src="{{ route( 'img.resize', [ $item->photo->photo.'?w=186&h=150&fit=crop' ] ) }}" class="img-responsive" onerror="imgError(this);" />
                @else
                    <img src="{{ asset(_no_image) }}" class="img-responsive"  />
                @endif
            </div>

            <div class="col-sm-8 col-md-9">
                <h5>{{$item->title}}</h5>
                <span class="line-price">Giá: {{number_to_text_vn($item->price)}}</span>
                <span class="line-title"><b>Địa chỉ: </b>{{$item->address}}</span>
                <span class="line"><b>Diện tích:</b> {{number_to_acreage_vn($item->acreage)}}</span>
                <span class="line-date">Ngày đăng: {{$item->created_at->format('d-m-Y')}}</span>

            </div>
        </div>

    </a>
</div>