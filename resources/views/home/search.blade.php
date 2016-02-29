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
         <table class="table table-striped table-hover ">
  <thead>
    <tr class="success">
        <th>Name</th>
        <th>Amount</th>
        <th>Type</th>
        <th class="text-warning">Category</th>
        <th>Date</th>
        <th>Plan</th>
        </tr >
  </thead>
        <tbody> 
            @foreach ($finances as $key => $finance)
        <tr class="info">
        <td>{{ $finance->name}}</td>
       <td>{{ $finance->amount}}</td>
        <td><?php echo ($finance->type == 0) ? "Expense" : "Income"; ?></td>
        <td class="text-warning">{{ $finance->category }}</td>
        <td>{{ $finance->created_at }}</td>
        <td>{{ $finance->plan }}</td>
    
     </tr>
      @endforeach
  </tbody>
  </table> 
</div>
{!! $finances->links() !!}
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#fcategory').change(function(){
            window.location.href = window.location.protocol + '//' + window.location.hostname + '' + window.location.pathname+'?keyword={{$keyword}}&cat=' + $('#fcategory').val();
        });
    });
</script>
@endsection
