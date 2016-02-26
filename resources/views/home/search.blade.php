@extends('layouts.app')
@section('content')

<div class="container">
    <div style="overflow: hidden;">
        <div class="col-md-4">
            <select id="fcategory" name="fcategory" class="form-control">
                <option>
                    ---- Please Select Category ----
                </option>
                @foreach($categories as $category)
                <option value="{{$category->id}}"  @if(old('fcategory') == $category->id) selected @endif >
                    {{$category->
                    name}}
                </option>
                @endforeach
                @if($user)
                @if($uCategories = $user->
                categories()->
                get())
                @foreach($uCategories as $category)
                <option value="{{$category->id}}" @if(old('fcategory') == $category->id) selected @endif >
                    {{$category->
                    name}}
                </option>
                @endforeach
                @endif
                @endif
            </select>
        </div>
    </div>
    <div style="overflow: hidden;">
        <div class="col-md-2">#</div>
        <div class="col-md-2">Name</div>
        <div class="col-md-2">Type</div>
        <div class="col-md-2">Category</div>
        <div class="col-md-2">Date</div>
        <div class="col-md-2">Plan</div>
    </div>
    @foreach ($finances as $key => $finance)
    <div style="overflow: hidden;">
        <div class="col-md-2">{{$key+1}}</div>
        <div class="col-md-2">{{ $finance->name}}</div>
        <div class="col-md-2"><?php echo ($finance->type == 0) ? "Expense" : "Income"; ?></div>
        <div class="col-md-2">{{ $finance->category }}</div>
        <div class="col-md-2">{{ $finance->created_at }}</div>
        <div class="col-md-2">{{ $finance->plan }}</div>
    </div>
    @endforeach
</div>
{!! $finances->links() !!}
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#fcategory').change(function(){
            window.location.href = window.location.protocol + '//' + window.location.hostname + ':8080' + window.location.pathname+'?keyword={{$keyword}}&cat=' + $('#fcategory').val();
        });
    });
</script>
@endsection
