<div class="it-post clearfix">
    <a href="{{ route('portal.news.show', [$item->category->url_rewrite, $item->url_rewrite]) }}" title="{{$item->url_rewrite}}">
        <div class="row">
            <div class="col-sm-4 col-md-3">
                @if(! is_null($item->photo))
                    <img src="{{ route( 'img.news.resize', [ $item->photo.'?w=186&h=150&fit=crop' ] ) }}" class="img-responsive" onerror="imgError(this);" />
                @else
                    <img src="{{ asset(_no_image) }}" class="img-responsive"  />
                @endif
            </div>

            <div class="col-sm-8 col-md-9">
                <h5>{{$item->title}}</h5>
                <span class="line-title">{{$item->description}}</span>
                <span class="line-date">Ngày đăng: {{$item->created_at->format('d-m-Y')}}</span>

            </div>
        </div>

    </a>
</div>