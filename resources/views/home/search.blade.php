@extends('layouts.app')
@section('content')
<div class="container">
    <div style="overflow: hidden;">

        <div class="col-md-4">
            <select id="fcategory" name="fcategory" class="form-control">
                <option>
                    ---- Please Select Category ----
                </option>
                @if(isset($categories))
                @foreach($categories as $category)
                <option value="{{$category->id}}"  @if(old('fcategory') == $category->
                    id) selected @endif >
                    {{$category->
                    name}}
                </option>
                @endforeach
                @if($user)
                @if($uCategories = $user->
                categories()->
                get())
                @foreach($uCategories as $category)
                <option value="{{$category->id}}" @if(old('fcategory') == $category->
                    id) selected @endif >
                    {{$category->
                    name}}
                </option>
                @endforeach
                @endif
                @endif
                @endif
            </select>
        </div>
    </div>

    <div style="overflow: hidden;">
        <table class="table table-striped table-hover ">
            <thead>
                <tr >
                    <th>
                        Name
                    </th>
                    <th>
                        Amount
                    </th>
                    <th>
                        Type
                    </th>
                    <th >
                        Category
                    </th>
                    <th>
                        Date
                    </th>
                 <th>
                        Plan
                    </th>
                </tr >
            </thead>
            <tbody>
            @if(isset($finances))
                @foreach ($finances as $key =>
                $finance)
                <tr >
                    <td>
                        {{ $finance->
                        name}}
                    </td>
                    <td>
                        {{ $finance->
                        amount}}
                    </td>
                    <td>
                        <?php echo ($finance->
        type == 0) ? "Expense" : "Income"; ?>
                    </td>
                    <td class="text-warning">
                        {{ $finance->
                        category }}
                    </td>
                    <td>
                        {{ $finance->
                        created_at }}
                    </td>
                   <td>
                        {{ $finance->
                        plan }}
                    </td>
                </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    @if(isset($finances))
    {!! $finances->
    links() !!}
    @endif
    @endsection
    @section('script')
    @if(isset($keyword))
    <script>
        function parseQueryString(val) {
            var result = "Not found",
            tmp = [];
            var items = location.search.substr(1).split("&");
            for (var index = 0; index < items.length; index++) {
                tmp = items[index].split("=");
                if (tmp[0] === val) result = decodeURIComponent(tmp[1]);
            }
            return result;
        }
        $(document).ready(function(){
            $('#fcategory').val(parseQueryString('cat'));
            $('#fcategory').change(function(){
                window.location.href = window.location.protocol + '//' + window.location.hostname + '' + window.location.pathname+'?keyword={{$keyword}}&cat=' + $('#fcategory').val();
            });
        });
    </script>
    @endif
    @endsection
