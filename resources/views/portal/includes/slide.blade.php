<div id="slider">
    <ul class="slides">
        @foreach($sliders as $slide)
            <li>
                <img src="{{ asset($slide->file_path) }}" alt="{{$slide->file_name}}" />
            </li>
        @endforeach
    </ul>
</div>