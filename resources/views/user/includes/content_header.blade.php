<section class="content-header">
  	@if( !empty($breadcrumbs) )
  	<ol class="breadcrumb">
    	@foreach( $breadcrumbs as $item )
    		<li>
          @if( !empty($item['link']) )
          <a href="{{ $item['link'] }}">
          @endif
    		    @if( !empty($item['icon']) )
            <i class="{{$item['icon']}}"></i>
            @endif
            {{ $item['title'] }}
          </a>
        </li>
      @endforeach
  	</ol>
    @endif

    @if( !empty($action) )
      <a href="{{$action['link']}}" class="btn btn-default action-button">@if( !empty($action['icon']) )<i class="{{$action['icon']}}"></i>@endif {{$action['title']}}</a>
    @endif
  	<div class="clearfix"></div>
</section>